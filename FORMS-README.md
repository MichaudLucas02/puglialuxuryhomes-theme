# Forms Documentation

This theme includes two main forms for user interaction: the **Booking Request Form** and the **Villa Submission Form**.

---

## 1. Booking Request Form

**Location**: Single Villa Template (`single-villa.php`)  
**Purpose**: Allow visitors to request a booking for a specific villa  
**Handler**: `plh_handle_booking_request()` in `functions.php`

### Form Fields

- **Villa** (hidden): Automatically populated with villa ID and name
- **Name*** (required): Guest's full name
- **Email*** (required): Guest's email address
- **Check-in Date*** (required): Arrival date
- **Check-out Date*** (required): Departure date
- **Comments / Requirements**: Additional guest requests or requirements
- **Honeypot Field** (hidden): Anti-spam protection

### How It Works

1. **Submission**: Form submits to `admin-post.php` with action `plh_booking_request`
2. **Security**: 
   - Nonce verification prevents CSRF attacks
   - Honeypot field catches spam bots
3. **Validation**:
   - Checks all required fields are filled
   - Validates email format
   - Ensures dates are provided
4. **Email Notification**: Sends HTML-formatted email to `info@puglialuxuryhomes.com` with:
   - Guest contact information
   - Villa name and ID
   - Check-in/check-out dates
   - Guest comments
5. **User Feedback**:
   - Success: Shows green confirmation message
   - Error: Shows red error message with details

### Email Recipient

**Hardcoded to**: `info@puglialuxuryhomes.com`

To change the recipient email, edit the `$to` variable in the `plh_handle_booking_request()` function in `functions.php`.

### CSS Classes

- `.villa-booking-form`: Main form wrapper
- `.form-message.success`: Success message styling (green)
- `.form-message.error`: Error message styling (red)

---

## 2. Villa Submission Form

**Location**: Property Management Template (`property-management.php`)  
**Purpose**: Allow villa owners to submit their property for listing on the platform  
**Handler**: `plh_handle_villa_submission()` in `functions.php`

### Form Fields

- **Your Name*** (required): Owner's full name
- **Email Address*** (required): Owner's email
- **Phone Number**: Owner's contact phone (optional)
- **Villa Name*** (required): Name of the villa
- **Villa Location*** (required): City, Region
- **Number of Bedrooms*** (required): Bedroom count
- **Villa Description*** (required): Detailed description of the villa, features, and amenities
- **Additional Information**: Any other relevant details (optional)
- **Honeypot Field** (hidden): Anti-spam protection

### How It Works

1. **Submission**: Form submits to `admin-post.php` with action `plh_villa_submission`
2. **Security**:
   - Nonce verification (`plh_villa_submission_nonce`)
   - Honeypot field for spam detection
3. **Data Sanitization**:
   - Text fields: `sanitize_text_field()`
   - Email: `sanitize_email()`
   - Textarea: `sanitize_textarea_field()`
   - Bedrooms: `intval()`
4. **Validation**:
   - Checks all required fields
   - Validates email format with `is_email()`
5. **Email Notification**: Sends HTML-formatted email to site admin with:
   - Owner's contact information (name, email, phone)
   - Villa details (name, location, bedrooms)
   - Full villa description
   - Additional information/notes
6. **User Feedback**:
   - Success: Redirects with `?villa_submission=success`
   - Error: Redirects with `?villa_submission=error&villa_error=[message]`

### Email Recipient

**Dynamic**: `get_option('admin_email')` - WordPress admin email

To use a specific email address instead, replace `get_option('admin_email')` with a hardcoded email in the `plh_handle_villa_submission()` function.

### CSS Classes

- `.villa-submission-section`: Section wrapper with light gray background
- `.villa-submission-form`: Form container with white card styling
- `.form-row`: Flex container for form fields
- `.form-row.full-width`: Full-width fields (textareas)
- `.form-col`: Individual field columns (50% width on desktop)
- `.submit-btn`: Teal submit button with hover effects
- `.form-message.success`: Success message (green)
- `.form-message.error`: Error message (red)

### Responsive Design

- **Desktop**: Two-column layout for inputs
- **Mobile** (< 768px): Single-column layout, reduced padding

---

## Security Features

Both forms implement:

1. **Nonce Verification**: WordPress security tokens prevent CSRF attacks
2. **Honeypot Fields**: Hidden fields catch spam bots (legitimate users won't fill them)
3. **Data Sanitization**: All inputs are cleaned before processing
4. **Email Validation**: Checks email format validity
5. **Required Field Validation**: Ensures critical information is provided

---

## Data Storage

**Important**: Both forms currently **only send emails** - submissions are not stored in the WordPress database.

If you need to:
- Track submissions in WordPress admin
- Create a submissions archive
- Enable admin review before processing

You would need to implement a custom post type and save submissions to the database.

---

## Customization

### Changing Email Recipients

**Booking Form** (`functions.php`, line ~1792):
```php
$to = 'info@puglialuxuryhomes.com'; // Change this email
```

**Villa Submission Form** (`functions.php`, line ~1836):
```php
$to = get_option('admin_email'); // Change to specific email if needed
```

### Adding/Removing Fields

1. Update the HTML form in the template file
2. Update the handler function to sanitize/validate new fields
3. Update the email template to include new fields
4. Update CSS if needed for styling

### Translating Forms

Both forms use translatable strings. To translate:
1. Use Loco Translate or edit the `.pot` file in `/languages/`
2. Key strings are wrapped in `plh_t()` or `plh_booking_text()` functions
3. Re-sync translations after adding new strings

---

## Testing

To test the forms:

1. **Fill out the form** with valid data
2. **Check email delivery** - ensure emails arrive at the configured recipient
3. **Test spam protection** - fill the honeypot field to verify rejection
4. **Test validation** - submit with missing required fields
5. **Test error handling** - submit with invalid email format

---

## Troubleshooting

**Emails not sending:**
- Check WordPress mail configuration
- Install SMTP plugin (WP Mail SMTP, etc.)
- Check spam folders
- Verify recipient email address is correct

**Form not submitting:**
- Check browser console for JavaScript errors
- Verify nonce is being generated
- Check PHP error logs

**Validation errors:**
- Ensure all required fields have `required` attribute
- Check field names match handler expectations
- Verify honeypot field is hidden (`display:none`)
