<?php

namespace XMLWorld\ApiClient;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use SimpleXMLElement;

use XMLWorld\ApiClient\Interfaces\Serializable;
use XMLWorld\ApiClient\Interfaces\Serializer;

class SerializeXML implements Serializer
{
	/** @var array <string, array<string>> */
	protected static array $constructorParams = [];

	protected function boolIf(mixed $value) : string
	{
		if(!is_bool($value)){
			return htmlspecialchars($value);
		}

		return $value ? 'True' : 'False';
	}

	public function serialize(Serializable $serializableObject): string
	{
		$class_name = substr(strrchr(get_class($serializableObject), '\\'), 1);

		$xml = new SimpleXMLElement("<$class_name></$class_name>");

		/** @var object $serializableObject */ // <-- for phpstan
		foreach($serializableObject as $key => $value){

			//if it's a Serializable object...
			if($value instanceof Serializable){

				//we need to replace the member for the class
				$childDom = dom_import_simplexml($xml->addChild($key));

				$childDom->parentNode->replaceChild(
					$childDom->ownerDocument->importNode(
						dom_import_simplexml(new SimpleXMLElement($this->serialize($value))),
						true
					),
					$childDom
				);
			//if it's a built-in object or of other kind...
			} else {
				//if not null...
				if(!is_null($value)) {
					//if it's an array...
					if(is_array($value)){
						foreach($value as $val){
							$xml->addChild(ucfirst($key), $this->boolIf($val));
						}
					} else {
						$xml->addChild(ucfirst($key), $this->boolIf($value));
					}
				}
			}
		}

		$customXML = $xml->asXML();

		//we remove the xml version
		return trim(substr($customXML, strpos($customXML, '?>') + 2));
	}

	public function unSerialize(string | SimpleXMLElement $payload, string $namespace = ''): Serializable
	{
		if(is_string($payload)){
			$payload = simplexml_load_string($payload);
		}

		//if nameexit(__FUNCTION__.PHP_EOL);space is empty...
		if(empty($namespace)){
			//we try to deduce whether it's a request or a response from the root name
			if(str_ends_with($payload->getName(), 'Response')){
				$namespace = 'XMLWorld\\ApiClient\\Responses';
			} elseif(str_ends_with($payload->getName(), 'Request')){
				$namespace = 'XMLWorld\\ApiClient\\Requests';
			}
		}

		//if we couldn't deduce it from the root name...
		if(empty($namespace)){
			//we try whether a response fist then a request
			$className = "XMLWorld\\ApiClient\\Responses\\{$payload->getName()}";

			//we check whether the class exists
			if(!class_exists($className)){
				$className = "XMLWorld\\ApiClient\\Requests\\{$payload->getName()}";
			}
		//if we could deduce it we get the corresponding namespace
		} else {
			$className = "{$namespace}\\{$payload->getName()}";
		}

		//if the class didn't exist anyway
		if(!class_exists($className)){
			//we try the common classes
			$className = "XMLWorld\\ApiClient\\Common\\{$payload->getName()}";
		}

		//we check whether the class exists
		if(!class_exists($className)){
			throw new \Exception("[$className] class does not exist");
		}

		$args = [];

		foreach($payload as $element => $value){
			$paramName = lcfirst($element);
			//if the element has children...
			if($value->count()){
				if($payload->{$element}->count() > 1){
					$args[$paramName][] = $this->unserialize($value, $namespace);
					continue;
				}
				$args[$paramName] = $this->unserialize($value, $namespace);
				continue;
			}

			if($payload->{$element}->count() > 1){
				$args[$paramName][] = (string) $value;
				continue;
			}

			$args[$paramName] = $value;
		}

		//if not cached yet...
		if(!isset(self::$constructorParams[$className])){
			$reflectionClass = new ReflectionClass($className);
			$params = $reflectionClass->getConstructor()->getParameters();

			foreach($params as $param){
				self::$constructorParams[$className][] = $param;
			}
		}

		$args2 = [];

		array_map(
			function($item) use ($args, &$args2) {
				/** @var ReflectionParameter $item */
				$paramName = lcfirst($item->getName());

				/** @var ReflectionNamedType $type */
				$type = $item->getType();

				//if there is a value for that parameter...
				if(isset($args[$paramName])){
					if(is_array($args[$paramName]) //if it's an array like when the param is variadic
						|| $args[$paramName] instanceof Serializable //or it's Serializable
					){
						$param = $args[$paramName];
					} else {
						//otherwise we cast it into string as it's only one value
						$param = (string)$args[$paramName];

						//if the string is empty it might be that it's a self-closed element
						if (empty($param)) {
							if (!$type->isBuiltin() //if the type isn't int, float, string, etc, it must be a class
								&& in_array(Serializable::class, class_implements($type->getName())) //if the param is supposed to be Serializable
							) {
								//it means that the xml element was self-closed
								$param = null;
							}
						//if not empty
						} else {
							if($type->isBuiltin()){
								if($type->getName() == 'bool'){
									$param = strtolower($param) != 'false';
								} else {
									settype($param, $type->getName());
								}
							}
						}
					}

					//if the param is variadic and it's the only one...
					if($item->isVariadic()
						&& count($item->getDeclaringFunction()->getParameters()) == 1
						&& is_array($param) //and the value is an array
					){
						//we pass the array straight as the only param
						$args2 = $param;
					} else {
						if(is_array($param)) {
							$args2 = array_merge($args2, $param);
						} else {
							if($type->isBuiltin()){
								if($type->getName() == 'bool'){
									$param = is_bool($param) ? $param : strtolower($param) != 'false';
								} else {
									settype($param, $type->getName());
								}
							}

							$args2[] = $param;
						}
					}
					return;
				}
				$args2[] = null;
			},
			self::$constructorParams[$className]
		);
/*
		if($className == 'XMLWorld\ApiClient\Responses\BookingDetails') {
			var_dump($args2);
			exit('lololo');
		}
*/
		return new $className(...$args2);
	}
}