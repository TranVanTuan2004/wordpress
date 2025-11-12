# Movie Theme

A minimal starter WordPress theme for building a movie site. It provides a `movie` custom post type, `genre` taxonomy, simple templates, and a `[movie_list]` shortcode to display movies.

Installation

1. Copy the `movie-theme` folder into `wp-content/themes/`.
2. In WordPress admin, go to Appearance -> Themes and activate "Movie Theme".
3. Go to Movies -> Add New to create movie posts. Add featured images.
4. Create a page, select the "Movie List" template to show movie grid, or insert the shortcode `[movie_list]`.

Notes

- Permalinks: after activating, go to Settings -> Permalinks and save to flush rewrite rules.
- This is a starter theme. Extend with templates, archive filters, player integration, and styles as needed.

Shortcodes

- [movie_list posts_per_page="12" genre="action"] - show movies.
