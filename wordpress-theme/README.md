# Horizon Moto Guides – WordPress theme

This theme is the Horizon Moto Guides site rebuilt for WordPress. It looks the same as the original site, but you can edit every tour, route, guide, mountain pass, article and page section in WordPress admin without touching code.

## 1. Set up WordPress on Spaceship

1. In your Spaceship account, open **Hosting Manager** for your web hosting plan and make sure your domain is connected to it.
2. Use the **WordPress installer** in Hosting Manager to install WordPress on your domain. Write down the admin username and password you choose.
3. Go to `https://your-domain.com/wp-admin` and log in.

## 2. Install the theme

1. Get the theme file `horizon-moto.zip`. To build it, run `python3 tools/build_wp_theme.py` from the project folder. The file is created at `.tmp/horizon-moto.zip`.
2. In WordPress, go to **Appearance → Themes → Add New Theme → Upload Theme**.
3. Choose `horizon-moto.zip`, click **Install Now**, then **Activate**.
4. A green notice confirms that your content was added. Activation automatically:
   - creates the pages Home, Tours, Booking, Blog, Guides, Suggest a Ride, and a private Admin Dashboard
   - adds all 6 tours, 5 top routes, 3 guides, 29 mountain passes and 6 blog articles
   - sets Home as the homepage and Blog as the posts page
   - creates the main menu
   - switches links to the "Post name" style, which the route pages need

## 3. Finish setup (about 10 minutes)

1. **Contact details and form email:** go to **Appearance → Customize → Horizon Moto Settings**.
   - **Contact details**: address, phone, public email, hours and the support line.
   - **Footer and social**: footer text, Instagram and Facebook links. The social links stay hidden until you add them.
   - **Form emails**: where booking requests and ride suggestions are sent. If you leave this blank, they go to the WordPress admin email.
2. **Test both forms.** Submit a test booking on the Booking page and a test suggestion on the Suggest a Ride page, then check that the emails arrive.
   - Shared hosting email often lands in spam or never arrives. If that happens, install the free **WP Mail SMTP** plugin and connect it to your email account, e.g. Spacemail or Google Workspace.
3. **Replace the stock photos.** Every tour, route, guide and article currently uses a stock photo from Unsplash. To use your own, open the item and set its **Featured image**. The homepage background is the Featured image of the **Home** page.

## 4. Where to edit what

| To change… | Go to… |
|---|---|
| Tours (name, price, type, region, description, "i" tooltip, photo, order) | **Tours** in the admin menu |
| Top Routes (the footer list and each route's page) | **Top Routes** |
| Guides | **Guides** |
| Mountain pass statuses on the dashboard (Open / Advisory / Closed) | **Mountain Passes** |
| Blog articles and categories | **Posts** |
| Home page hero, stats, pricing cards, "Why ride with us", testimonials | **Pages → Home**, in the "Home page sections" box below the editor |
| Page titles and intro text (Tours, Booking, Guides, Blog, Suggest a Ride) | **Pages →** that page. The title is the big heading and the page text is the intro under it. |
| Tours page steps, Booking page cards and FAQ, Guides page safety cards, Suggest a Ride features and stats | **Pages →** that page, in the sections box below the editor |
| Dashboard tiles, advisory notice, policies | **Pages → Mission Telemetry & Fleet Control** |
| Header and footer menu | **Appearance → Menus** (Main menu) |
| Contact details, social links, form email | **Appearance → Customize → Horizon Moto Settings** |

**Display order:** tours, routes and guides appear in the order set by **Order** in the "Page Attributes" box on each item's edit screen, lowest number first. The home page shows the first 4 tours.

### "One item per line" fields

Many section fields hold a list. Put each item on its own line and separate the parts with a `|` character. For example, the FAQ field:

```
Can I create my own custom route? | Absolutely. Our guides can build a custom itinerary around your preferred roads and pace.
How do I pay for my reservation? | Our team will confirm your booking and share secure payment options.
```

The help text under each field says which parts it expects. To remove an item, delete its line. To add one, add a line.

## 5. About bookings

The Booking page sends you an **email request** with the tour, preferred date, name (as on ID), email, number of riders, skill level and notes. No payment is taken online. You confirm each booking and arrange payment yourself. You can add an online booking and payment plugin later. The tour cards' "Reserve your spot" buttons already preselect the right tour on the booking form.

## 6. The private Admin Dashboard

The "Mission Telemetry & Fleet Control" page is set to **Private**, so only logged-in editors and administrators can see it. They see an **Admin Dashboard** link in the site header. Its buttons open the WordPress editors for passes, tours and the dashboard itself.
