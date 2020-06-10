# Social Share

A Social Share plugin that renders the social share icons

## Frontend PHP

Create an instance of the class and call the method which prints out the html:

### You can add this into any page e.g. index.php or single.php or page.php
### Even on a post loop all you need to do is add the post id as a parameter e.g.

```
<?php echo mwb_get_social_share()->getSocialHtml('Share News Article');?>
```

```
[mwb_social_share]
```

## CMS Options

Check an acf option page called social share and that is where all the cms options you are able to select

### Important Note

* Extend the class name into your child theme if you want to extend the function to your own liking