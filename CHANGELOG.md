# Changelog

## 2025-04-03 3.5

- Updated URLs to reduce redirects
- Bug fix: Footer menus on multisites to be controlled by blog 1

## 2025-03-21 3.4.2

- Font encoding fix

## 2025-03-21 3.4.1

- a11y: Adjusted blog tags to remove background opacity and improve contrast.
- Bug fix: Tabs and tour targeting via URL.
- Bug fix: Pointer access to the search field.

## 2025-02-18 3.4

- Various PHP syntax changes for PHP 8.2.x error mitigation
- Bug fix: Formidible Form CSS conflicts with checkboxes and radio buttons
- Changed excerpt output modifications to only include Continue reading links in template loops
- Quicklinks link update for it.uw.edu

## 2024-10-28 3.3.1

- Bug fix: RSS shortcode from UW sources showing image when show_image is set to false

## 2024-10-17 3.3.0

- Added visual hierarchy styling to headings used inside card body that are not card title
- Updated markup order for step cards, while maintaining visual layout
- Fixed green success badge/button so it used the correct, accessible background color
- Adjusted Bootstrap custom checkbox label spacing
- Updated all widget titles (both core WordPress widgets and custom UW widgets) to be h2s, while keeping same styling from h4s
- Removed unneeded aria-hidden and role=”search” from search toggle, fixed aria-hidden on search area disclosure (leftover from 2014)
- In search disclosure, moved search form options to the left side of the search field instead of after the submit button, updated initial focus to be with the search options (first form field) instead of the search term input field; modernized layout markup, related tweaks for mobile
- Replaced slash separator in breadcrumbs with a border element instead of a content slash, moved from :before to :after to more accurately reflect where it is; added color change on hover to match other links
- Removed unneeded aria-hidden on Quicklinks button
- Updated audience menu and footer hover color, other footer hover/active/focus behavior; modernized the footer code while keeping layout, including replacing slash separator with a border element
- Updated sidebar page nav use an aria-label that matches the text of the top-level item so it is announced to assistive technology correctly as “<top-level item> navigation”
- Updated aria-labels to be more clear in header, footer, and widgets
- Fixed role and aria-label application for hero image in various header options
- Bugfix for jumbotron shortcode

## 2024-9-6 3.2

- Improved Bootstrap styling
-- Fixed description list alignment
-- Fixed form styling & layout
-- Added form styles for Contact Form 7 and Gravity Forms
-- Corrected contrast issues on small.muted-text, code element, and alerts
-- Corrected mark styling to have color and background color
- Added ARIA role="navigation" to audience menu
- Added ARIA role="region” for hero area in all templates
- Corrected sidebar search submit button low contrast
- Corrected empty h4 in Recent Posts widget if no title provided
- Removed role="complementary" from widgets that are in the sidebar <aside>
- Improved aria labels for sidebar, widgets, and page title banner to more accurately describe sections
- Added ARIA role=”region” to accordion collapse element
- Removed unneeded role=”presentation” on RSS, Recent Posts, and Blogroll widget links, added aria-hidden to image only
- Added title to generic “more” link on RSS widget to elaborate on link context
- On the blog single posts, updated Previous and Next links to use <strong> markup instead of CSS font-weight property.
- Restored plus and play icon button styling (bug introduced in 3.1)
- Potentially breaking change: Changed Tabs to use a button instead of an a:link for the tab trigger. Existing functionality remains but because we changed from a to button, if anyone has built off expecting this being a link in your child theme, you’ll need to update your child theme to reflect button vs a.
- Potentially breaking change: Changed Carousel previous & next buttons to be buttons instead of links. Styling did not change but if the links were used in a child theme override you’ll need to update your child theme to reflect they are now buttons vs links.

## 2024-7-23 3.1

- Added feature to use any web icon on buttons
- Added ability to link directly to Tabs/Tours
- Added non-bold text option to accordion style
- Bug: fixed issues with radio button and checkbox styles, converted to CSS
- Bug: fixed figure caption typo on galleries
- Bug: various blogroll & RSS widget image fixes
- Bug: fix image alignment issue on blogs

## 2023-12-19 3.0.1

- Bug fix: radio buttons and checkboxes not displaying properly

## 2023-8-4 3.0.0

- Upgraded jQuery version
- New card shortcode style option: Half Block
- Updated the mobile version of Tours to match Tabs
- Added a branded caption option to the gallery shortcode
- Added post dates to search results page
- Added option to turn sidebar on for attachment pages
- Added option to enable sidebar navigation on homepage
- Added option to change position of mega menu dropdowns
- Added option to toggle post thumbnail output on Prev / Next Post links on the bottom of single blog/post pages
- Added external link icon for navigation menus items
- Added image credit field to attachment pages
- Added unique IDs to all shortcode output
- Added ability to expand/link to Accordion section from a URL
- Added setting to add custom text to the 404 pages
- Added light grey background option to grid shortcode
- Added stretch link option to card shortcode
- Removed Super Admin / Admin permissions checks for menu updates
- Removed iFrame allow list from theme
- a11y: output mobile jumbotron image above the text
- Bug: fixed heading clear issue
- Bug: Fix media modal popup errors when linked to attachment pages
- Bug: Fixed contact widget displaying improperly when multiple long entries are added
- Bug: Fixed grid shortcode mobile spacing issue
- Bug: Classic menu automatically wraps when there are more than 8 items


## 2023-8-4 2.3.1

- Fixed a fatal error affecting some versions of PHP & WordPress

## 2023-7-31 2.3

- Removed unneeded dev files
- Updated dev packages
- Removed unneeded dev packages
- Removed unnecessary gulp tasks
- Moved sass sourcemaps into css folder
- PHP 8 error mitigation

## 2023-3-22 2.2.2

- Default navigation updated URLs to minimize redirects

## 2023-3-16 2.2.1

- Hotfix: Default navigation update

## 2023-2-27 2.2.0

- Added option to enable feature images displaying on posts and blog listing
- Removed unused mobile menu template file
- Updated iframe allow list
- Removed Super Admin requirement on page meta boxes
- Bug: corrected UW Web Strategy Team email in Dashboard widget
- Bug: removed author from subpage list shortcode output
- Bug: removed author line from non-post content templates
- Bug: updated permissions check on menus to function on single site installs

## 2022-11-17 2.1.1

- Added accessible text reference to README
- Updated UW Recent Posts widget to add class to title

## 2022-11-15 2.1.0

- Changed brand colors in Site Notification Banner to better align with the brand
- Bug: fixed footer link alignment
- Bug: added proper markup to site notification banner output
- Bug: fixed link colors on site notification banner
- Bug: fixed accordion button output missing tag closure
- Bug: fixed attachment template author byline output
- Bug: equal height and width adjustments to grid shortcode

## 2022-11-08 2.0.1

- Removed non-brand color options to Site Notification Banner
- Bug: Changed notification banner field to textarea
- Bug: Fixed default header mobile site title css

## 2022-11-02 2.0.0

- Theme Panel renamed to UW Theme Settings and given updated labels and styles
- Added mobile Jumbotron styles
- Updated Page Template mobile styles for Big and Small Hero template
- Updated visual styles for bulleted lists and links across card and jumbotron styles
- tweaks and updates to the grid shortcodes to work with Bootstrp layouting
- ReadMe updates

### Accessibility
- Updated cards to have title above image in html code
- Unnecessary headings removed from footer
- Fixed quicklinks tab focus accessibility issue

### New Features
- Additional button styles for downloads and videos
- Option to remove title overlay from Big and Small hero template and show the title lower on the page
- Options to turn off breadcrumbs and quicklinks on the site
- Site-wide Notification banner utilizing Bootstrap alert styles
- Blog options, styles, and templates added
- Jumbotron Hero Template option for pages
- Attachment pages
- Changed footer menu to a WordPress menu location for easy update and customization
- Buttons optional on jumbtrons
- Added favicon to theme
- Masonry gallery layout option
- Added URL parameter to Trumba shortcode

### Bug fixes
- Various mobile CSS tweaks and bug fixes
- Fixed an issue with single accordions not rendering properly
- Fixed and issue with buttons in Safari
- Fixed widget image card upload button bug
- Fixed nesting headings under headings on the Mega Menu
- Fixed mobile menun button appearing above UW Alert
- Fixed header breakpoint issues with search and quicklinks button
- Fixed current page indicator on sidebar navigation
- Fixed sidebar navigation not appearing when no widgets were enabled
- Fixed tagboard shortcode to match new embed version
- Various javascript bug fixes

## 2022-06-17 1.3.3

- bugfix: pdf attachment pages
- added top level links for academics and research
- theme panel: new post options section with additional post meta options

## 2022-05-27 - 1.3.2

*  bugfix: quicklinks and skiplink tab navigation bugs
*  bugfix: search url defaulting to the main site URL and not a subpage

## 2022-04-21 - 1.3.1

- bugfix: search escape key
- bugfix: fixed showing featured image as default template banner
- feature: added title tag option to card and jumbotron shortcodes

## 2022-04-20 - 1.3.0

- feature: added theme option to change default search option
- a11y: various navigation navigation fixes (white bar, quicklinks, audeince menu), including updates to keyboard navigation, arial labels, and JAWS interactivity
- a11y: Added visible focus indicator outline to links and menus
- a11y: Added background colors to headers & jumbotrons
- a11y: fixed contrast errors in masthead, footer, some list items, and search input field
- a11y: various accessibility adjustments to shortcodes
- fix: content css bugfixes
- fix: added check for $post to mitigate error on child theme
- fix: error mitigation for activating audience menu
- cleanup: reorganized assets


## 2022-01-25 - 1.2.0

- Allow youtube embeds in modal shorcodes
- updated/modernized quicklinks and footer links
- added quicklinks disable setting back into the theme and templates
- Moved all image and icon assets to the assets folder
- Updated installation instructions to include renaming zip files to uw_wp_theme.zip
- Fix: removed feature image output & double page title on templates
