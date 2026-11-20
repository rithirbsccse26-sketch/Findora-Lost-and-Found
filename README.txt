FINDORA - QUICK SETUP

1. Extract Findora_website.zip.
2. Copy the Findora folder into C:\xampp\htdocs
3. Open XAMPP Control Panel and start Apache.
4. Open http://localhost/Findora/ in your browser.

No MySQL is needed. The website uses PHP and JSON files.

FEATURES
- Dashboard with community statistics
- Register, log in and log out
- One combined Report Lost / Found form
- Optional photo upload from your computer or phone (JPG, PNG, GIF or WEBP; 5 MB maximum)
- Browse, search and filter by type and category
- View item details
- Contact the person who posted an item with a private message form
- Inbox for messages received on your own reports
- My Reports page
- Save/bookmark items
- Mark your own report as Returned

BEGINNER NOTES
- users.json stores accounts (passwords are hashed).
- items.json stores lost/found reports.
- uploads/ stores photos attached to reports.
- messages.json stores contact messages.
- saved.json stores each user's saved item IDs.
- Messages are not a live chat. A user sends one message using the contact form, and the report owner sees it in their Messages inbox.

IMPORTANT
This is a classroom/demo project. For a real public website, add stronger security, input checks, moderation, HTTPS and backups.
