# wp-google-reviews-plugin

WordPress Plugin to include Google Place's Reviews, in a GDPR- and nDSG-save way

## How to use

- Install this plugin
- Enable this plugin
- Go To Tools -> Google Reviews and set your Google Places API key
- Use the Shortcode `[google-review place-id="your-place-id"]`, with the id of the place whose reviews you would like to display

## How it works

All in all, it just does all the downloading of data on the server-side, and then caches the results for two days. 
Images (icons etc.) from Google are downloaded via a small proxy, in order not to leak the client's IP to Google.

## How to develop

- Clone this repository
- Run `composer install` in this directory
- Run `yarn` in this directory
- Run `yarn build` everytime you would like to build the Svelte application
