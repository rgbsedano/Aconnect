# Admin Manual Draft - Admin Side

## Content
I. Admin Login  
II. Dashboard  
III. Pending Employers  
A. Pending Employer Review  
B. Approved Employers  
C. Rejected Employers  
IV. User Accounts  
A. Search and Filter  
B. View Alumni Profile  
C. Edit Account  
D. Delete Account  
V. Alumni Officers  
A. Officer Listing  
B. Add Officer  
C. Edit Officer  
D. Delete Officer  
VI. Employer Accounts and Page Visibility  
A. Page Visibility Settings  
B. Employer Groups  
VII. Job Posting  
A. Job Listings  
B. View Applicants  
C. Edit and Delete Posting  
D. Notify Alumni  
VIII. Events  
A. Event Listing  
B. Create Event  
C. Edit Event  
D. Delete Event  
IX. Posting  
A. Platform Posts  
B. Carousel / Banner Management  
X. Support Inbox  
XI. Reports / Analytics  
XII. Activity Log  

## I. ADMIN LOGIN PAGE

**MODULE NAME (ADMIN LOGIN PAGE)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 1.1. Admin Login Page**

The Admin Login page is used by administrators to access the backend management panel. It requires a valid admin username and password. After successful authentication, the system redirects the user to the admin dashboard.

To access the module:
1. Open the admin login page from the system URL.
2. Enter the administrator username and password.
3. Click the Log In button.
4. Wait for the system to redirect you to the Admin Dashboard.

Notes:
- The login page is separate from the alumni login page.
- The controller stores admin session data such as admin ID, username, email, and role after successful login.

## II. DASHBOARD

**MODULE NAME (DASHBOARD)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 2.1. Admin Dashboard**

The dashboard provides a high-level summary of system activity. It displays counts for alumni, officers, job postings, events, platform posts, and admin access. The dashboard cards also act as quick links to the main management pages.

To access the module:
1. Log in as an administrator.
2. Review the summary cards shown on the dashboard.
3. Click a card to open the related management page.

Common dashboard shortcuts:
- Community Events
- Platform Posts
- Job Opportunities
- Active Officers
- Support Chat
- Admin Access / User Accounts

## III. PENDING EMPLOYERS

**MODULE NAME (PENDING EMPLOYERS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 3.1. Pending Employers Page**

The Pending Employers module is used to review employer accounts before they are allowed to log in and post jobs. It shows Pending, Approved, and Rejected tabs with search and pagination support.

### A. PENDING EMPLOYER REVIEW

Each pending record shows the company name, email, contact person, and status. The administrator can approve or reject the account directly from the table.

Steps:
1. Open the Pending Employers page.
2. Browse the Pending tab or search for a company name or email.
3. Review the employer details.
4. Click Approve or Reject.
5. Wait for the confirmation message and email notification.

### B. APPROVED EMPLOYERS

The Approved tab lists employers whose accounts are already enabled. This view is useful for checking which companies currently have access.

### C. REJECTED EMPLOYERS

The Rejected tab lists employer accounts that were declined during review. Administrators can use it to confirm prior decisions or review history.

## IV. USER ACCOUNTS

**MODULE NAME (USER ACCOUNTS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 4.1. User Accounts Page**

The User Accounts module allows administrators to manage alumni records. The page supports search, paginated results, profile viewing, editing, and soft deletion.

### A. SEARCH AND FILTER

The admin can search alumni by name, email, student number, or related details. Results refresh through AJAX to keep the table responsive.

### B. VIEW ALUMNI PROFILE

The View Profile action opens a profile summary modal that shows the alumni's photo, student number, status, email, phone, degree, graduation year, last login, and other basic information.

### C. EDIT ACCOUNT

The Edit Account modal lets the administrator update:
- Student number
- First name and last name
- Email
- Phone
- Gender
- Profile image
- Password, if a new one is provided

Steps:
1. Open the User Accounts page.
2. Click Edit on the selected alumni record.
3. Update the required fields.
4. Save the changes.

### D. DELETE ACCOUNT

Deleting an account performs a soft delete and also marks related records as deleted in messages, connection requests, job applications, and event registrations.

Notes:
- The delete action is protected and must be sent as a POST request.
- Profile images are stored under `assets/uploads/alumni/`.

## V. ALUMNI OFFICERS

**MODULE NAME (ALUMNI OFFICERS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 5.1. Officers Page**

This module is used to manage official alumni officers displayed in the system. The page includes a table view, search, pagination, and modal-based create/edit actions.

### A. OFFICER LISTING

Each officer entry shows the name, gender, position, email, biography, photo, and status.

### B. ADD OFFICER

Administrators can add a new officer using the create modal.

Steps:
1. Open the Officers page.
2. Click Add Officer.
3. Fill in the officer details.
4. Upload a photo if available.
5. Save the record.

### C. EDIT OFFICER

The edit modal allows administrators to update officer details and replace the current photo.

### D. DELETE OFFICER

Deleting an officer removes the database record and also deletes the uploaded photo file if one exists.

## VI. EMPLOYER ACCOUNTS AND PAGE VISIBILITY

**MODULE NAME (EMPLOYER ACCOUNTS AND PAGE VISIBILITY)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 6.1. Page Visibility Settings**

This module is used to control what employer accounts can see in the admin-employer experience. The admin can manage page visibility and group assignments for employers.

### A. PAGE VISIBILITY SETTINGS

The Page Visibility screen lets the administrator enable or disable employer access to specific pages such as Job Posting, User Accounts, Alumni Officers, Events, Posting, Support, and Reports.

How to use it:
1. Open the Page Visibility page.
2. Select an employer.
3. Toggle the visibility switches for each page.
4. Wait for the system to save the changes automatically.

### B. EMPLOYER GROUPS

Employer Groups let administrators organize employers into named groups and assign employers to groups.

Common actions:
- Create a new group
- Rename a group inline
- Add or remove employers from a group
- Delete a group when it is no longer needed

### C. EMPLOYER APPROVALS (ADMIN)

The Employer Approvals module lets administrators review new employer registrations and either approve or reject them. It provides three status tabs (Pending, Approved, Rejected), a live search box, and pagination.

How to use (Admin):
1. Open the Pending Employers page in the Admin panel (`Admin -> Pending Employers`).
2. Switch between the `Pending`, `Approved`, and `Rejected` tabs to review accounts in each state.
3. Use the search field to find an employer by company name, contact name, or email. The live search triggers when typing 3+ characters or when the field is cleared.
4. To approve an account, click the approve (check) button on the row. This sends a POST request to the server.
5. To reject an account, click the reject (X) button on the row. This also sends a POST request to the server.
6. After an action, a confirmation message is shown and an email notification is attempted to the employer.

Behavior and notes:
- Approve sets `approval_status` = `approved` and `is_active` = 1.
- Reject sets `approval_status` = `rejected` and `is_active` = 0.
- The approve/reject actions are protected and must be performed via POST requests from the admin UI.
- Pagination is per-tab and query parameters preserve tab state (e.g., `approved_page`, `rejected_page`).

Developer references (where the functionality lives):
- Controller: [application/controllers/Admin.php](application/controllers/Admin.php#L1)
- Model: [application/models/Employer_model.php](application/models/Employer_model.php#L1)
- Main view (tabs, search, approve/reject forms, JS): [application/views/admin/pending_employers.php](application/views/admin/pending_employers.php#L1)
- AJAX partial used for rendering rows: [application/views/admin/_employer_rows.php](application/views/admin/_employer_rows.php#L1)
- AJAX endpoint for live search: `Admin/ajax_search_employers` (returns rendered rows)
- Approve/Reject endpoint: `Admin/verify_employer/{id}/{approve|reject}` (expects POST)
- Email notifications: `Admin::send_employer_notification()` reads SMTP config from environment variables prefixed with `ACONNECT_SMTP_`.

Troubleshooting tips:
- If the employer list is empty, confirm the `employers` database table exists and includes an `approval_status` column.
- If live search does not update rows, check browser console network calls to `Admin/ajax_search_employers` and ensure the response contains valid HTML.
- If notification emails fail, verify SMTP environment variables and that the application can connect to the SMTP server.

Suggested manual content to include in Admin training:
- Screenshot of the Pending Employers tab showing the search box and action buttons.
- Step-by-step approve/reject workflow with expected confirmation messages.
- Note about the soft-delete / is_active behavior and where to find records in the Approved / Rejected tabs.

### D. EMPLOYER EXPERIENCE — REGISTRATION & LOGIN

This section describes what employers (external users) see and how they interact with the system when creating accounts and signing in.

Employer registration (public):
1. Visit the Employer Registration page (`/employer_register`).
2. Fill in required fields: Company name, First/Last name, Phone (country code + number), Email, Password, Confirm Password, and "How did you hear about us".
3. Submit the form. If validation fails, the form will re-display errors.
4. On success, the user is shown a success message and can proceed to login.
5. If email verification is required, the system sends a verification link; users can use the "Resend verification" flow on the login page.

Key behavior and notes:
- Passwords are hashed using `password_hash(..., PASSWORD_BCRYPT)` on registration.
- The registration controller ensures unique emails (`is_unique[employers.email]`).
- The `employers` table may be modified on-the-fly by the controller to add `verification_token` and `verification_sent_at` columns when resending verification emails.

Developer references (employer auth):
- Registration controller: [application/controllers/Employer_register.php](application/controllers/Employer_register.php#L1)
- Registration view: [application/views/user/employer_register.php](application/views/user/employer_register.php#L1)
- Verification/resend flow: `Employer_register::resend_verification()` and `Employer_register::verify_email()`

Employer login (employer-facing):
1. Visit the Employer Login page (`/employer_login`).
2. Enter company email and password and submit.
3. If the account is `pending` or `rejected`, the system displays an informative message and prevents login.
4. On successful authentication the session is populated with `login_status`, `user_id`, `user_type='employer'`, `company_name`, and cached `employer_groups` for the user.
5. Employers are redirected to the employer job posting area (controller: `Employer_job_posting`) after login.

Developer references (employer login):
- Login controller: [application/controllers/Employer_login.php](application/controllers/Employer_login.php#L1)
- Login view: [application/views/employer/login.php](application/views/employer/login.php#L1)

Troubleshooting tips (auth):
- If login always fails, check the stored password format in the `employers` table (bcrypt vs plain). The login accepts both hashed and legacy plain passwords but recommend migrating to bcrypt.
- If verification emails are not sent, verify SMTP environment variables and the `send_email` configuration.

### E. EMPLOYER JOB POSTING & PROFILE (EMPLOYER PORTAL)

Employers who are logged in can post jobs, edit and delete their job listings, and manage profile/settings (including groups they belong to).

Posting a job (employer):
1. After login, navigate to the Post a Job page (`Employer_job_posting::index` -> view: `application/views/employer/job_posting.php`).
2. Use the job form to provide Job Title, Description, Category, Salary Range, and Location.
3. Submit the form to create a job. On success, the job appears in "Your Posted Jobs" below the form.
4. Employers may edit or delete only their own jobs; access is checked by comparing `jobs.employer_id` with the session `user_id`.

Profile and settings (employer):
- Access profile and settings at `employer_profile` (controller: [application/controllers/EmployerProfile.php](application/controllers/EmployerProfile.php#L1), view: [application/views/employer/profile.php](application/views/employer/profile.php#L1)).
- Sections include Account, Security, Communications, Devices, Privacy, and My Groups.
- Employers can update their email (`update_email()`), view group membership, and refresh/invalidate cached group data.

Developer references (jobs & profile):
- Employer job controller: [application/controllers/Employer_job_posting.php](application/controllers/Employer_job_posting.php#L1)
- Job data model: [application/models/Job_model.php](application/models/Job_model.php#L1)
- Employer profile controller: [application/controllers/EmployerProfile.php](application/controllers/EmployerProfile.php#L1)
- Employer profile view: [application/views/employer/profile.php](application/views/employer/profile.php#L1)

Notes and troubleshooting (jobs & groups):
- Jobs table migrations exist under `application/migrations` (see `009_add_employer_id_to_jobs.php`). Ensure `employer_id` exists and has the correct foreign key mapping.
- Employer groups are stored in `employer_groups` and assignments in `employer_group_assignments`. The system caches group membership in memcached; clear cache if membership changes do not appear.
- If employers cannot see their posted jobs, confirm `jobs.employer_id` matches the logged-in `user_id` and `jobs.status` is `active`.


## VII. JOB POSTING

**MODULE NAME (JOB POSTING)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 7.1. Job Posting Page**

The Job Posting module allows administrators to manage job listings, review applicants, edit vacancies, delete posts, and notify alumni. Employers may also access this page if the page is made visible to them.

### A. JOB LISTINGS

The job list shows the job title, company, applicant count, location, salary range, and action buttons.

### B. VIEW APPLICANTS

Clicking a job opens the applicant modal showing alumni who applied for that job.

### C. EDIT AND DELETE POSTING

Administrators can edit the job posting details or delete the post if it is no longer valid.

### D. NOTIFY ALUMNI

The page includes a Notify Alumni action to send job-related notifications.

## VIII. EVENTS

**MODULE NAME (EVENTS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 8.1. Events Page**

The Events module is used to create, update, and remove community events. The page shows summary cards for total events, upcoming events, and reach.

### A. EVENT LISTING

Each event row includes the event name, date, location, status, and action buttons.

### B. CREATE EVENT

Administrators can create a new event using the create event button and fill in the event details.

### C. EDIT EVENT

The edit modal lets the administrator update the event name, date, location, duration, contact person, description, and image.

### D. DELETE EVENT

Deleting an event performs a soft delete by setting the deleted date.

## IX. POSTING

**MODULE NAME (POSTING)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 9.1. Platform Posting Page**

The Posting module is used to manage platform announcements, news, success stories, and carousel banners.

### A. PLATFORM POSTS

Administrators can create posts by entering a title, content, post type, and optional image. Posts can be filtered by category such as announcements, news, and stories.

### B. CAROUSEL / BANNER MANAGEMENT

The page also supports uploading and deleting banner images for the homepage carousel.

Common actions:
1. Create a post.
2. Upload a banner image.
3. Delete outdated carousel items.

## X. SUPPORT INBOX

**MODULE NAME (SUPPORT INBOX)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 10.1. Support Inbox**

The Support Inbox module lets administrators view messages sent by alumni and respond to them from the admin interface.

To use the module:
1. Open the Support Inbox page.
2. Select a conversation from the list.
3. Read the latest messages.
4. Type a reply and send it.

Notes:
- The support chat displays the alumni list and opens a chat panel for the selected user.
- Messages are stored through the support messaging model used by the system.

## XI. REPORTS / ANALYTICS

**MODULE NAME (REPORTS / ANALYTICS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 11.1. Reports Dashboard**

The Reports module provides engagement analytics and employment database reporting. It also includes AI-generated interpretation text based on the available data.

### A. ANALYTICS OVERVIEW

The report page summarizes alumni engagement trends, event registrations, and job applications by graduation year.

### B. EMPLOYMENT DATABASE

Administrators can filter employment records by graduation year, employment status, and submission date range.

### C. EXPORT OPTIONS

The report can be exported to Excel or PDF for offline review and sharing.

### D. AI ANALYTICS INTERPRETATION

The system generates a short insights section to help administrators interpret the report data faster.

### E. BUTTONS & ACTIONS (Plain language)

- Export Excel: Downloads the report as an Excel file you can open in Excel or Google Sheets.
- Export PDF: Saves the current report (charts and tables) as a PDF for printing or sharing.
- Download CSV: Downloads the table data as a CSV file for simple spreadsheet use.
- Print: Opens your computer or browser print dialog so you can print the current screen.
- Apply Filters: Uses the filters you chose (like year or date range) and updates the report to show those results.
- Reset Filters: Clears any filters and shows the standard (default) report again.
- Refresh: Loads the latest data from the server so the charts are up to date.
- Share: Lets you copy a link or send the report by email to someone else.
- AI Interpret / Regenerate: Updates the short AI-written summary for the currently shown data.


## XII. REPORTS & ANALYTICS

**MODULE NAME (REPORTS & ANALYTICS)**  
**Font:** Times New Roman, **Size:** 20, **Style:** Heading 1

IMAGE  
(SCREENSHOT)

Make sure the image attached is visible and readable.

**Figure 12.1. Reports & Analytics Page**

The Reports & Analytics module provides administrators with visual summaries and exportable data for alumni engagement, event registrations, job applications, and employment tracer records. It also shows automated AI interpretations where available.

To use the module:
1. Open the Reports & Analytics page (`/AdminReports` or the Analytics link in the admin header).
2. Use the filters (graduation year, date range, report type) to narrow results.
3. Review charts and the AI interpretation panel for quick insights.
4. Export the report using the **Export Excel** or **Export PDF** buttons.
5. Print or save the exported file for offline review.

### Buttons & Actions (Plain language)

- Export Excel: Click to download the report as an Excel file you can open in Excel or Google Sheets.
- Export PDF: Click to save the report (charts and tables) as a PDF file for printing or sharing.
- Download CSV: Click to download the table data as a CSV file for spreadsheets.
- Print: Click to open the print dialog and print the current view.
- Apply Filters: Use this after choosing filters (year, date range, report type) to update the report.
- Reset Filters: Click to clear filters and return to the default view.
- Refresh: Click to reload the report so you see the most recent data.
- Share: Click to copy a link or send the report by email.
- AI Interpret / Regenerate: Click to re-run the short AI summary for the data you are viewing.

### Support Chat — simple explanation (what users see and where to find it)

- What users see: There is a small floating "AConnect Support" button at the bottom-right of the site. Click it to open a chat window where you can type a quick question and send it. Messages are saved so the support team can reply.
- What admins see: Admins use the Support Inbox page to see incoming messages and reply. When an admin opens a conversation it appears as a chat modal (a popup) where they can type and send replies.
- Where the code lives (for developers):
	- Floating support widget: [application/views/__footer.php](application/views/__footer.php#L104) — this file shows the floating button and the small chat window that appears on every page.
	- Admin inbox and reply modal: [application/views/admin/support_inbox.php](application/views/admin/support_inbox.php#L332) — this page shows the admin view and the popup used to reply.
	- Server logic that saves and retrieves messages: [application/controllers/Support.php](application/controllers/Support.php#L1) — the code that actually receives messages and returns chat history.

Notes:
- The floating widget is placed in the site footer so it appears on all pages.
- To change visible text or button labels, edit the small chat markup in the footer or the admin inbox page.

## CONTACT INFORMATION

For any questions, clarifications, or technical issues regarding the use of the system, you may contact:

Name: ____________________  
Email: ____________________  
Contact Number: ____________________  
Office/Department: ____________________

### Contact Buttons / Actions (Plain language)

- Email: Click the email link or Email button to open your mail app with the address filled in.
- Call: On a phone, click the phone number or Call button to start a call.
- Copy: Click Copy to copy the contact's name, email, and phone so you can paste them elsewhere.
- Open Map: Click to open a map app or map website showing the office location.
- Submit Issue / Support: Click this to open the Support chat/inbox and send a message, including screenshots if needed.
- Visit Department Page: Click to go to the department's page for more contact details.

Notes:
- After an action, the system shows a small message confirming it worked (for example, "Copied to clipboard" or "Email client opened").
- Messages sent through Support are saved so admins can track and reply to them.