# Migrating UW 2014 Widgets & Shortcodes

The [uw-2014 theme](https://github.com/uweb/uw-2014) contains a number of widgets and shortcodes that we would like to migrate over to the new theme. All of them are controlled by PHP Classes and contain some mixture of CSS/SCSS, PHP, HTML, and JavaScript to achieve their functionality. We need to migrate all of this to the new theme while not breaking the coding conventions in place in Golden Snitch **or** making the migration process for our theme users difficult.

## Working in uw-2014

All of the Widget and Shortcode PHP features live in the **setup/** and **widgets/** folders. Their LESS files live in the **less/** folder. Any Javascript may live in the JS folder as libries or be interspersed in the code.

>Note: Lauren is well versed in the theme so feel free to ask her if you don't know where something is.

Some of the shortcodes also contain widget code and vice-versa.

Because everything in uw-2014 is contained in a class, the class file is called and then intialized before it can be used. [See an example of that here in the main uw-2014 shortcode class file](https://github.com/uweb/uw-2014/blob/master/setup/class.uw-shortcodes.php).


## Where things should go in Golden Snitch

I've already started some of the migration process in the new theme. Those files live in **dev/inc/shortcodes** or **dev/inc/widgets**, and rarely **dev/inc/2014**. You'll need to decide which folder makes the most sense for which feature, depending on what it does.

Some of the shortcodes and widgets are already moved, but they need to be re-tested thoroughly and have their code updated where changes need to be made. We also need to make sure the LESS (which needs to be converted to SASS) and Javascript associated with them moves as well.

## Steps to moving a feature from uw-2014 to golden snitch

1. Grab [the latest uw-2014](https://github.com/uweb/uw-2014), we'll be pulling files directly from this.

1. Check out the develop branch and do a `git pull` to make sure it's up to date with what's been committed.

2. Create a feature branch following the instructions in the [Dev Workflow doc](https://github.com/uweb/golden-snitch/blob/develop/DevWorkflow.md).

3. Make sure you have [debugging on for WordPress](https://wordpress.org/support/article/debugging-in-wordpress/) so you can see any errors that come up.

3. Grab the file related to your shortcode or widget from uw-2014 and place it in Golden Snitch at **dev/inc/shortcodes/shortcodes.php** if it's a shortcode OR **dev/inc/widgets/widgets.php** if it's a widget.

4. Include and initialize the class in **dev/inc/shortcodes/shortcodes.php**, following how the previous shortcodes have been included and initialized. If it's a widget, you can skip this step.

5. Test the shortcode/widget. You can take a look at the [uw-2014 ReadMe](https://github.com/uweb/uw-2014#uw-2014-theme) and test out all the settings and functionality for each shortcode.

6. Check the debug logs in WordPress to find any errors or warnings. There are a lot of different ones that might come up, but we can work together to strategize how to keep them updated.

7. When you're done, create a pull request from the **feature/** branch to the **develop** branch.

8. Once we both have a chance to test and review on our local machines, merge it into the **develop** branch.