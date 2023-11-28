# api-client

Simple connection to the xml.world API

## Instalation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require xml-world/api-client

## Description

This library provides a quick way to integrate your booking system with the XML.world API.

You will be able to search for hotel accommodation scoped by several criteria, to book rooms, to check bookings, to 
update the reference as a trade, and to cancel it if needed.

The API will return and exhaustive summary of your booking.

## Use

You first need to apply for trading credentials from XML World.

Once you have them, you can start the API like this:

```php
$xmlClient = new XMLClient(login: 'login', password: 'password');
```

The XMLClient exposes object exposes 5 methods from the API at XML World.

### Search request

With this request, we send the criteria of our search in order to retrieve the list of stock that fulfills them.  

We make use of the **SearchDetails** class which accepts params like *arrivalDate*, *duration*, *regionID*, *roomRequests*
*properties*, *propertyID*, *mealBasisID*, *minStarRating*, *minimumPrice*, and *maximumPrice*.  

```php
$searchDetails = new SearchDetails(
	arrivalDate: '2023-09-01',	        // arrival date
	duration: 5,				// duration in days
	roomRequests: new RoomRequests(		// list of rooms
		RoomRequest::fromAges(2),
		RoomRequest::fromAges(
			1,		        // number of adults
			16,		        // age of first child (variadic)
			8,		        // age of second child
			2		        // age of third child
		),
	),
	properties: new Properties(19, 21),	// list of properties if searching for some
	propertyID: null,			// if only one we can use this param, but they exclude each other
	mealBasisID: 0,				// meal basis
	minStarRating: 0,			// filter by star rating
	minimumPrice: 0,			// filter by minimum price
	maximumPrice: 0				// filter by max price
);
```

The params *roomRequests* and *properties* are lists of room requested and properties. We express those lists with the 
objects **RoomRequests** and **Properties**.  

**RoomRequests** accepts a list or **RoomRequest** objects where we specify the number of adults and the ages of 
non-adult visitors.  
Each **RoomRequest** instance is a different room we request for.

**Properties** accepts a list of property IDs. It is used when we request for several hotels. If we are only interested 
in one hotel we can leave this param **null** and use *propertyID*. Both parameters are mutually exclusive.

The example is searching for rooms from the properties whose IDs are **19** and **21** two rooms, one for two adults
and another run for an adult with 3 underage. The system will deduce that the 2-year-old child is actually an infant.

Finally, we post the request:

```php
try {
	$result = $xmlClient->search(searchDetails: $searchDetails);
} catch (Throwable $e) {

}
```

In **$result** we get the outcome of the request.
It is a **SearchResponse** object.
If the **ReturnStatus** is true,
it will bring a list of rooms that match our searches in a **PropertyResults** object or an error message otherwise.

### Book request

With the **roomIDs** we obtain from the previous request now we can book the rooms.

In order to do that, we construct a **BookDetails** object. This object accepts some of the same params of the
**SearchDetails** object like *arribalDate* and *duration* and further params like *tradeReference*, *totalPrice*,
*leadGuest*, *roomBookings*.

```php
$bookingDetails = new BookDetails(
	arrivalDate: '2023-11-01',
	duration: 5,
	tradeReference: 'TEST_REF',
	totalPrice: 1040,
	leadGuest: new LeadGuest(
		firstName: 'TestLeadFName',
		lastName: 'TestLeadLName',
		title: 'Mr'
	),
	roomBookings: new RoomBookings(
		new RoomBooking(
			roomID: 20011,
			mealBasisID: 6,
			adults: 2,
			children: 0,
			infants: 0,
			guests: new Guests(
				new Guest(
					type: 'Adult',
					firstName: 'TestGuestFName',
					lastName: 'TestGuestLName',
					title: 'Mrs',
					age: null,
					nationality: 'French'
				)
			)
		),
	)
);

```
The names tell what those params are for. 

It is important to mention that **totalPrice** is optional but
advisable to use. It makes sure that we book at exactly the specified price if it's still available, otherwise 
it will book at whatever the curren price is.  
This is to avoid the scenario where we do a search and get rooms and prices, but the book later
and the price has changed, and it could be both lower and higher.

The *leadGuest* param admits a **LeadGuest** object which has to have *firstName*, *lastName* and *title* at minimum
but it can have more details.
This is the first guest, and it's assumed that goes in the first room of the book.

The *roomBookings* param admits a **RoomBookings** object, which is a list of rooms and accepts one or more
**RoomBooking** objects.

Each **RoomBooking** object has the *roomID*, *mealBasisID*, which are the room and meal plan codes from the 
previous search request.

Then the *adults*, *children* and *infants*, which are the number of each for this room.

Finally, *guests* which accepts a **Guests** object that represents the lists of guests for this room.

If the room only has the lead guest, we can set **null** and if there are more guests along, we don't need to include it here.

Each **Guest** object has *type* whether adult, child or infant. The *firstName* and *lastName*. The *age* which
is **null** if it's an adult and specified if a child. And the nationality.

Now we can post the book:

```php
try {
	$result = $xmlClient->book(bookingDetails: $bookingDetails);
} catch (Throwable $e) {

}
```
The var *$result* will be a **BookResponse** object which again, if **ReturnStatus** is **true**, *bookingDetails*
will be a **BookingDetails** object with the list of rooms we just booked, their special offers, supplements, taxes, 
cancellation policies if any and hotel details as well as the booking reference at XML World.
An error message otherwise.

### Booking request

Booking request is for retrieving the current status of our booking at XML World.

```php
try {
	$result = $xmlClient->booking(reference: $bookingReference);
} catch (Throwable $e) {
}
```
We provide the XML World booking reference we got from the book request, and we get a **BookingResponse** object that is
identical to the **BookResponse** object from the book request.

### Booking update request

Booking update request is for setting the trade reference.

```php
try {
	$result = $xmlClient->bookingUpdate(reference: $bookingReference, tradeReference: $tradeReference);
} catch (Throwable $e) {
}
```

The method accepts the booking reference given in the **BookRequest** or **BookingRequest** requests and the trade reference.
It returns a **BookingUpdateRequestResponse** object that holds the same data as **BookResponse**.

### Cancel request

With the Cancel request, we do that, cancel the booking.

```php
try {
	$result = $xmlClient->cancel(reference: $bookingReference, reason: $cancellationReason);
} catch (Throwable $e) {
}
```

The method accepts the booking reference given in the **BookRequest** or **BookingRequest** requests and the trade reference.
It returns a **CancelResponse** that in principle is like an **BookResponse** but informing about the cancellation success.

Once we cancel a booking, **BookingRequest** returns a **BookingResponse** object that holds the same details as this **CancelResponse**.

## Development environment

XMLClient supports two environments, live (by default), and devel.

Live attacks the API in production, and the calls produce real results and bookings.

Devel attacks our staging environment and the data might mirror production, but bookings don't have a real effect.

To activate the devel environment, do this:

```php
$env = XMLClient::ENV_DEV;

$xmlClient = new XMLClient(login: $login, password: $password, env: $env);
```
You just need to specify the dev environment by passing the constant **XMLClient::ENV_DEV** as third parameter.

If you ever need to request a different server in your development environment for tests purposes, you can do so this way:

```php

XMLClient::setDevURL('your own dev url');

```

## Logging

XMLClient also provides a way to log calls and responses.

In order to do that, you need to implement the Interface Logger:

```php

$myLogger = function($payload){
	echo $payload;
};

//you can implement the Logger interface to inject your logging implementation in the client.
$logging = new class($myLogger) implements Logger
{
	protected Closure $myLogger;
	
	public function __construct(Closure $myLogger)
	{
		$this->myLogger = $myLogger;
	}

	public function logRequest(string $log): void
	{
		($this->myLogger)($log);
	}

	public function logResponse(int $statusCode, string $log): void
	{
		($this->myLogger)($log);
	}
};

$xmlClient = new XMLClient(login: $login, password: $password, env: $env, logger: $logging);
```
For example, we build this anonymous class that implements **Logger** and injects whatever logging object we use as a forth parameter.

## Examples

you can find examples of use in the folder examples/

1. For searching, in **search_example.php**.
2. For booking, in **book_example.php**.
3. For retrieving a booking, in **booking_example.php**.
4. For updating a booking, in **booking_update_example.php**.
5. For canceling a booking, in **cancel_example.php**.
6. for logging injection, in **logging_injection_example.php**.


