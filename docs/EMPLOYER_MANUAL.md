# Employer User Manual

Version: 1.0
Updated: 2026-06-08

## Overview

This document describes the employer-facing flows in AConnect: registration, login, job posting, profile/settings, and employer groups. It is intended for employer users and site operators who support employers.

## 1 — Registration

Path: `/employer_register`

Plain description:
Employers register by providing company and contact details and a password; the system validates the input and sends a verification email when enabled.

For developers:
- `application/controllers/Employer_register.php`
- `application/views/user/employer_register.php`

## 2 — Login

Path: `/employer_login`

Plain description:
Employers sign in with email and password; accounts that are pending or rejected cannot sign in and the page shows a clear message.

For developers:
- `application/controllers/Employer_login.php`
- `application/views/employer/login.php`

Troubleshooting:
- If sign-in is blocked, the account may be under review (`pending`) or rejected — contact support.
- If you do not receive emails, ask support to check the mail settings.

## 3 — Job Posting (Employer Portal)

Path: Employer dashboard -> Post a Job (`Employer_job_posting` controller)

Plain description:
Logged-in employers can post, edit, and remove their own job listings using a simple form; posted jobs appear immediately on the dashboard.

For developers:
- `application/controllers/Employer_job_posting.php`
- `application/models/Job_model.php`
- `application/views/employer/job_posting.php`

Notes for support:
- If a job does not show up, check that it was created under the correct employer account and that it is marked active.

Create Posting modal (buttons)
- `Create Posting` (opens modal): opens the form to enter the job details.
- `Publish Now` (in modal): publishes the job immediately so it appears on your employer dashboard and is visible to applicants.
- `Cancel` (in modal): closes the form without saving any changes.
- Targeted groups selector: lets you pick one or more groups to target for this job; use Ctrl (or Cmd) to select multiple.

Create Posting modal (inputs)
The form asks for the job title, company name, location, pay range, job description, required qualifications, and target groups so you can publish a complete job post in one place.

Candidates and contact modal
When you open a job's candidate list, you can see each applicant's name, email, and application date, then either view their profile, contact them by email, close the list, or export the list for later use.

Applicant Details screen
This screen shows one applicant's profile summary and match details for the job, so you can review their background and decide whether to move forward with them.

Contact Applicant modal
This modal lets you compose and send an email to an applicant (or save a draft), with fields for From, To, Subject and Message, plus buttons to `Save as Draft`, `Use Email Template`, `Schedule Interview`, `Accept Applicant`, and `Reject Applicant`.

## 4 — Profile & Settings

Path: `employer_profile` controller (Profile Settings pages)

Plain description:
The Profile area lets employers update account details and preferences and view their group memberships; changes save immediately.

For developers:
- `application/controllers/EmployerProfile.php`
- `application/views/employer/profile.php`

Cache note:
- Group membership is cached to improve performance. If group changes are not visible, the cache may need to be cleared.

Account Information (plain)
This area shows your basic account details: account type (Employer), the email on file with a `Change` link to update it, your company name with a `Change` link (feature may be disabled), and a `Sign out` action to end your session.

Security Options (plain)
This section lists your security controls: change your password, enable two-factor authentication for extra protection, and view recent login activity so you can spot suspicious access.

Communications Settings (plain)
Use this area to control which emails and alerts you receive — toggle general notifications, job application alerts, and marketing emails on or off to suit your preferences.

## Codebase

Plain description:
This section maps the employer-facing features to the code files that implement them for quick developer reference.

For developers:
- `application/controllers/EmployerProfile.php`: handles profile pages and endpoints for Account, Security and Communications sections.
- `application/views/employer/profile.php`: profile UI with sections `#account`, `#security`, and `#communications` (sidebar + main content).
- `application/controllers/Employer_job_posting.php`: job posting, editing and deletion actions in the employer portal.
- `application/models/Job_model.php`: data access and queries for jobs.
- `application/models/Employer_model.php`: employer CRUD, search and approval-status updates.
- `application/controllers/Employer_register.php`: employer signup, verification and email sending.
- `application/controllers/Employer_login.php`: authentication and session handling for employers.
- `application/controllers/Admin.php`: admin approval flow that controls employer activation (`pending_employers`, `verify_employer`).
- `application/views/admin/pending_employers.php`: admin UI rendering the pending employer list.
- Database: key tables are `employers`, `jobs`, `employer_groups`, and `employer_group_assignments` (see SQL dumps in the repo).

Notes:
- Some UI elements in the profile view (change password, enable 2FA, communications toggles) are currently links/placeholders and may need backend handlers added.
- Use the controller methods above when wiring API endpoints or debugging approval/login issues.

### Button actions (plain descriptions)
Below are the interactive buttons and controls grouped by area, described in everyday language so non-technical readers can understand what each one does.

Job posting
- Create / Post job: Opens a form where you enter job details; submitting the form publishes the job so it appears on your dashboard.
- Edit job: Opens the job form pre-filled so you can change details and save updates.
- Delete job: Removes the job from your list after you confirm.

Profile & Settings
- Sidebar tabs (Account, Security, Communications, Devices, Privacy, My groups): switch between different settings pages for your account.
- Email "Change": opens a prompt to enter a new email and then updates your account email.
- Company "Change": currently a placeholder that shows a message — company name edits are not yet enabled.
- Sign out: signs you out of the site.
- Change password / Enable 2FA / View history: visible options that either open a form or will be enabled later; they control how you sign in and your account security.
- Communications toggles: checkboxes to choose whether you get emails or alerts (currently they are UI options; saving them may require a follow-up step).
- Group card: tap a group to see more details and the jobs posted by group members.

Registration
- Register: fill the sign-up form to create an employer account; you'll get instructions if email verification is required.
- Resend verification: request the verification email again if you didn't receive it.

Login
- Sign in: enter your email and password to access the employer dashboard.
- Logout: ends your session and returns you to the login page.

Admin / Approval
- Approve / Reject (admin only): administrators review new employer sign-ups and approve or reject accounts; this determines whether an employer can sign in.
- Search / refresh employer list: admin helpers to find and update lists of pending or approved accounts.

If you'd like, I can now (A) add short non-technical labels next to each button in the UI files, or (B) add direct file/line links for developers in a separate developer appendix.

## 5 — Employer Groups

Plain description:
Employer groups let admins organize companies into labeled groups; employers can view their groups but cannot change assignments.

For developers:
- Employer groups table: `employer_groups`
- Assignments table: `employer_group_assignments`
- Admin UI: `application/controllers/AdminPageVisibility.php` and `application/views/admin/*`

## 6 — Admin Approval Flow (How it affects employers)

Plain description:
New accounts may be placed in a pending state for admin review; approved accounts are activated and rejected accounts are disabled, with notifications sent for both outcomes.

For developers:
- `application/controllers/Admin.php` (pending/employer verification)
- `application/models/Employer_model.php`
- Admin view: `application/views/admin/pending_employers.php`

## 7 — Troubleshooting & Support

- Missing jobs: check `jobs.employer_id`, `jobs.status`, and query `Job_model::get_employer_jobs()`.
- Cannot register: confirm `employers` table exists and `email` field is not already in use.
- No verification email: verify SMTP env vars `ACONNECT_SMTP_*`, and check mail server connectivity.
- Cached groups not updating: flush memcached or call `EmployerProfile::refresh_groups_cache()`.

## 8 — Quick Admin Contact Template (for employers to send to support)

Please provide the following when contacting support:
- Company name
- Registered email address
- Screenshot of the error or message
- Time (with timezone) when the issue occurred

---

End of manual.
