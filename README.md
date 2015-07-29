# Ride: Social media widgets

A collection of widgets and REST clients allowing you to implement various social media integrations.

## Widgets
### Social media link widget

Select various social media services to display links to provided profile pages.

### Social media share widget

Select various social media services allowing the user to share the current page to them.

## Clients
###Flickr client
A minimalistic client and model which can ben used to send and handle requests to the Flickr API.

**Usage** : Request the first 5 photos of a specific Flickr photoset

	$flickrModel->setApiAuthentication(API_KEY, API_SECRET_KEY);
    $photos = $flickrModel->call('flickr.photosets.getPhotos', array(
    	'photoset_id': PHOTOSET_ID,
    	'page' => 1,
    	'per_page' => 5,
    ));


