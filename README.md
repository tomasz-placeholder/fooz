# Task 1: 
I'm creating a children theme using WP-CLI
`wp scaffold child-theme twentytwentyfive-child --parent_theme=twentytwentyfive --theme_name="Fooz" --author="Tomasz Frankowski" --activate`
I'm assuming parent theme has styling and functionality in line with currect guidelines in WordPress Handbook (https://developer.wordpress.org/themes/). I also assume that the theme is complete– I'm not adding any layout styles.
Custom CSS Rules would go to newly created style.css

# Task 2:
I'm loading js as 'fooz-script', and will use it to hold ajax code later.

# Task 3:
Created the taxonomy and CPT in functions.php. In bigger project I would extract this funcitonality to separate php file (for readability)

# Task 4:
Created `single-book.php` and `taxonomy-genre.php`, which handle the custom templates logic.

# Task 5:
Scaffolded block using `wp scaffold block faq-accordion --title="FAQ Accordion" --dashicon="smiley" --theme`
Since WordPress has a native details block, I'm going to create a new faq-accordion block, that will use Gutenberg template to display a `core/heading` followed by list of `core/detail`s, this handles all the interactivity on editor and front-end without any need to write custom code for it. 
Numbers added using css counter.
