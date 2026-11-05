# DF Builder

Oxygen-style page building inside the WordPress block editor, for Digitalfeet client sites.

**Requires:** WordPress 6.6+ (6.7+ recommended for live dynamic-data previews of core blocks), PHP 8.1+.

## What it adds

| Feature | Where |
|---|---|
| **Style panel** on DF Builder blocks and common core blocks (group, columns, paragraph, heading, image, buttons, list, cover). It covers layout (flex/grid), spacing, size, position, typography, background, border and effects, per **Desktop / Tablet / Landscape / Phone / Hover**. Empty fields show the inherited value. | Block sidebar → **Styles** tab |
| **Blocks:** Section, Div, Grid Columns, Heading, Text, Button, Image, Link Wrapper, Icon, Post Content | Inserter → *DF Builder* |
| **Global classes:** type a name in *Global classes* to create one, then switch *Editing* to that class to style every block that uses it. Classes are saved when you save the post or click *Save class*. | Style panel; manage/rename/delete in **DF Builder → Settings** |
| **Templates:** header, content (body) and footer templates with include/exclude conditions and a priority. When one matches, the theme output is replaced by the DF Builder canvas. | **DF Builder → Templates** |
| **Dynamic data:** bind text, URLs and images to post fields, custom fields, ACF fields, the author or the site, using the core Block Bindings API. | Block sidebar → **Dynamic data** |
| **Settings:** breakpoints, page width, gutter, and a global on/off switch for templates | **DF Builder → Settings** |

The breakpoint tabs follow the editor's device preview: Desktop maps to Desktop, Tablet to Tablet, and Mobile to Phone.

## How styles reach the page

- Every styled block gets a stable `dfb-<uid>` class. Its CSS comes from `schema/style-properties.json`, through `src/shared/css-generator.js` in the editor and `includes/class-style-engine.php` on the front end. **These two must stay identical.** `tests/fixtures/css.json` is the parity contract, and both test suites run it.
- CSS for the current post and the active templates is printed in `<head>`. Blocks discovered later in the render (query loops, reusable blocks) get their CSS in the footer.
- Global classes compile to `wp-content/uploads/df-builder/classes.css`. If uploads isn't writable, the CSS is printed inline instead.
- Values are validated against the schema's types, units, keywords and an allow-list of functions. Anything that could break out of a declaration is dropped.

## Development

```bash
npm install
npm run build        # or: npm start (watch)
npm test             # Jest: CSS generator + parity fixtures
npm run lint:js
composer install && composer test   # PHPUnit: Style_Engine parity + Conditions
npx wp-env start     # local WP at http://localhost:8888 (needs Docker)
npm run plugin-zip   # installable zip (uses the "files" list in package.json)
```

## Template tips

- Header and footer templates default to *Entire site*. Use exclude rules for landing pages.
- In a **content** template, add the **Post Content** block where the page body should go. For archives, use a core **Query Loop**.
- If several templates of one type match, the highest priority wins. Ties go to the more specific rule (a specific post beats a term, which beats a post type, which beats the entire site).
- To fall back to the theme everywhere without deleting anything, turn off *Use DF Builder templates* in Settings.
