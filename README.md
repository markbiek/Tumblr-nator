# Tumblr-nator

*Author:* Mark Biek

A simple website written for Via Studio as a code challenge.

## Notes
This exercise is loosely based on a [similar exercise](https://github.com/markbiek/TumblrAPIExample/) I did two years ago.

The previous version loaded all posts for the blog at once and pushed them directly into the CakePHP Paginator. Obviously this was quite slow.

The current version only loads the first 10 posts on page load. Subsequent pages are loaded when that page number is clicked on the pagination nav. The newly loaded pages are cached on the page so we don't have to make the same ajax calls over and over.

## Requirements
* Build a form that accepts a Tumblr blog name as its input and use the Tumblr API to retrieve posts for that blog.
* Results should be shown 10 at a time and have correctly functioning pagination links. ie. ‘next’ link only works if there are more posts, ‘3’ link should show results 21-30, etc.
* For each post, show it’s post ID, publish date and a link to the post on Tumblr.
* You may use the following API key: (api key provided)
* Use of a PHP framework is not required but strongly encouraged. You may choose the framework you are most comfortable with.
* An emphasis should not be given on design. However, the post results should still be readable.

## Implementation
* [CakePHP 3](http://cakephp.org/)
* [Bootstrap 3](http://getbootstrap.com/)

## Issues
* Pagination nav looks crappy on mobile
* On mobile, it's tricky to scroll the page down without scrolling the posts by accident
