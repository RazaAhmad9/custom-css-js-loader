# Custom CSS & JS Loader

**Contributors:** [ahmedraza-dev](https://ahmedraza.dev)  
**Tags:** custom css, custom js, enqueue scripts, header, footer  
**Requires at least:** 5.2  
**Tested up to:** 6.5  
**Requires PHP:** 7.4  
**Stable tag:** 1.0  
**License:** GPL v2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

A lightweight plugin to easily add custom CSS and JavaScript to your WordPress site — and choose whether to load them in the header or footer.

---

## Description

The **Custom CSS & JS Loader** plugin allows administrators to write and inject their own CSS and JavaScript code directly from the WordPress dashboard. Code can be added to either the `<head>` or before the closing `</body>` tag — making it perfect for adding quick styles, tracking codes, or any custom behavior without modifying your theme or installing bulky builders.

### Features

- Simple and clean settings panel in the WP Admin.
- CodeMirror-based editor for better coding experience.
- Inject CSS and JavaScript separately.
- Choose to enqueue in **header** or **footer**.
- No front-end dependencies added.
- Lightweight and developer-friendly.

---

## Installation

1. Upload the plugin files to the `/wp-content/plugins/custom-css-js-loader` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **Custom CSS & JS** from the admin menu.
4. Add your custom code, choose the placement, and save.

---

## Screenshots

1. Plugin settings page with CSS/JS code editors.
2. Code placement options (Header or Footer).
3. Syntax-highlighted editors using CodeMirror.

---

## Frequently Asked Questions

### Does this plugin affect website performance?

No. The plugin simply injects your custom code into the appropriate location in your site’s output. It does not enqueue additional libraries or frameworks.

### Can I use it for external scripts?

No, this plugin is meant for **inline code only**. If you want to load external scripts or styles, you'll need to modify your theme or use a different plugin.

---

## Changelog

### 1.0 – Initial Release
- Add custom CSS and JS editors.
- Choose injection point (header or footer).
- Syntax highlighting using WordPress Code Editor (CodeMirror).

---

## License

This plugin is licensed under the GPL v2 or later.  
See [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html) for details.

---

## Author

Developed by [Ahmad Raza](https://ahmedraza.dev)
