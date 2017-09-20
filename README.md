
# GDR-Scholars-Catalog-WordPress-Plugin
The GDR Scholars Catalog WordPress Plugin enables the GDR Catalog, a React.JS frontend application for the [ASU-USAID Fellowships program](https://schoolofsustainability.asu.edu/degrees-and-programs/graduate-degrees-programs/usaid-ri-fellowships/), to be deployed within a WordPress site via a shortcode.

# Requirements
* php > 5.5
* [GitHub Updater WordPress Plugin](https://github.com/afragen/github-updater)

## Setup and installation
* Download and install the [latest release package]().
* Activate the plugin in the WP Plugins Admin screen.
* Insert shortcode, [gdr-catalog], into page content area
* The "Full Width" page template is recommended for this application.



## Setup for Development
* **Install [Node 4.0.0 or greater](https://nodejs.org)**
* **Install [Yarn](https://yarnpkg.com/en/docs/install)** (Or use npm if you prefer)

## Development Usage
* Install required modules: `yarn` (or `npm install`)
* Build development version of app and watch for changes: `yarn build` (or `npm run build`)
* Build production version of app:`yarn prod` (or `npm run prod`)

## Quick Start
### Introduction
This plugin is based on the boilerplate plugin code from [WP-Reactivate](https://github.com/gopangolin/wp-reactivate). WP-Reactivate provides three different WordPress views in which an independant React app can be rendered:

- Shortcode
- Widget
- Settings page in the backend (wp-admin)

**NOTE: GDR-Scholars-Catalog-Wordpress-Plugin has disabled or removed unused portions of these views. Only the Shortcode view is currently in use.**


Each JavaScript root file will correspond to the independant React app to be bundled by Webpack.

*webpack.config.js*
```javascript =6
entry: {
  'js/admin': path.resolve(__dirname, 'app/admin.js'),
  'js/shortcode': path.resolve(__dirname, 'app/shortcode.js'),
  'js/widget': path.resolve(__dirname, 'app/widget.js'),
},
```

### Using the Shortcode
In order to get the shortcode attributes into our Javascript we need to pass them to an object which will be made available to the *shortcode.js* app via ```wp_localize_script```. Be careful with the security of data you pass here as this will be output in a ```<script>``` tag in the rendered html.

*includes/class-wpr-shortcode.php*
```php =79
public function shortcode( $atts ) {
  wp_enqueue_script( $this->plugin_slug . '-shortcode-script' );
  wp_enqueue_style( $this->plugin_slug . '-shortcode-style' );

  $object = shortcode_atts( array(
    'title'       => 'Hello world',
  ), $atts, 'gdr-catalog' );

  wp_localize_script( $this->plugin_slug . '-shortcode-script', 'wpr_object', $object );

  ?><div id="gdr-catalog-shortcode"></div><?php
}
```

You can access the shortcode attributes via the ```wpr_object``` in your React container component.

*app/containers/Shortcode.jsx*
```javascript =1
import React, { Component } from 'react';

export default class Shortcode extends Component {
  render() {
    return (
      <div className="wrap">
        <h1>WP Reactivate Frontend</h1>
        <p>Title: {wpr_object.title}</p>
      </div>
    );
  }
}
```

### Using the Settings Page
In our admin class we add a sub menu page to the Settings menu using ```add_options_page``` and register a setting to be used on the page.

We set ```'show_in_rest'``` to ```true``` when registering our setting in order to access our options via the REST API.

*includes/class-wpr-admin.php*
```php =187
public function register_settings() {
    register_setting( 'general', 'wpreactivate', array(
        'show_in_rest' 	=> true,
        'type'			=> 'string',
        'description'	=> __( 'WP Reactivate Settings', $this->plugin_slug )
    ) );
}
```

In the React container component we show how to retrieve and update this setting via the WordPress REST API default Settings  endpoint.

We polyfill the browser [Fetch API](https://developer.mozilla.org/en/docs/Web/API/Fetch_API) to make requests to the WordPress REST API. It is a powerful API, which can be seen as an evolution of XMLHttpRequest or alternative to jQuery.ajax().

*app/containers/Admin.jsx*
```javascript
getSetting = () => {
    fetch(`${wpr_object.api_url}settings`, {
        credentials: 'same-origin',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpr_object.api_nonce,
        },
    })
    .then(response => response.json())
    .then(
        (json) => this.setState({ settings: json.wpreactivate }),
        (err) => console.log('error', err)
    );
};
```
## Technologies
| **Tech** | **Description** |
|----------|-------|
|  [React](https://facebook.github.io/react/)  |   A JavaScript library for building user interfaces. |
|  [Babel](http://babeljs.io) |  Compiles next generation JS features to ES5. Enjoy the new version of JavaScript, today. |
| [Webpack](http://webpack.js.org) | For bundling our JavaScript assets. |
| [ESLint](http://eslint.org/)| Pluggable linting utility for JavaScript and JSX  |

## Credits
*WP-Reactivate boilerplate made by [Pangolin](https://gopangolin.com)*
