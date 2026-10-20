# Mahashankh Fashion Model Registration Form

A modern fashion model registration platform for **Mahashankh**, designed to collect model applications, manage applicant information, and accept registration payments securely through the Razorpay Payment Gateway.

## 📌 Project Overview

The Mahashankh Fashion Model Registration System provides an online registration process for aspiring fashion models. Applicants can fill out a registration form, submit their personal and professional details, upload their portfolio photographs, and complete the registration fee payment using Razorpay.

The platform aims to simplify the model application process with a responsive interface, secure payment integration, and efficient registration management.

## ✨ Key Features

### 1. Fashion Model Registration Form

- Collect applicant details, including:
  - Full Name
  - Email Address
  - Mobile Number
  - Date of Birth
  - Gender
  - City and State
  - Height and Other Modeling Details
- Allow applicants to provide their modeling experience.
- Upload portfolio photographs and profile images.
- Capture social media links and portfolio URLs.
- Validate required fields before submission.
- Display clear validation messages and submission status.

### 2. Razorpay Payment Gateway Integration

- Integrate Razorpay Checkout for registration fee payments.
- Support available payment methods enabled on the Razorpay account, such as UPI, cards, net banking, and wallets.
- Create payment orders securely through the backend.
- Verify payment signatures on the server.
- Maintain payment status for each registration.
- Display payment success, failure, and pending states.
- Prevent duplicate registration payments where applicable.

**Security:** Razorpay API secret keys must remain on the server and must never be exposed in frontend code.

### 3. Applicant Management

- Store applicant registration details in a database.
- Associate payment records with the relevant applicant.
- Track registration and payment statuses.
- Provide a foundation for an administrative dashboard to review applications.
- Support future features such as application approval, rejection, and audition scheduling.

### 4. Responsive User Interface

- Clean and modern fashion-industry-inspired design.
- Responsive layout for desktops, tablets, and mobile devices.
- User-friendly form fields and validation feedback.
- Clear registration and payment flow.
- Loading indicators and confirmation messages.

## 🛠️ Technology Stack

The exact stack depends on the implementation. A recommended architecture is:

| Technology | Purpose |
|---|---|
| React / Next.js | Frontend and application interface |
| HTML5, CSS3, JavaScript / TypeScript | UI and application logic |
| Node.js API / Next.js Route Handlers | Backend processing |
| Razorpay Checkout | Online payment interface |
| Razorpay Orders API | Payment order creation |
| Database (MongoDB or PostgreSQL) | Applicant and payment records |
| Cloud storage | Portfolio image uploads |
| Git and GitHub | Version control |

## 🔄 Registration Workflow

1. The applicant opens the Mahashankh fashion model registration page.
2. The applicant fills out the registration form.
3. The application validates the submitted information.
4. The backend saves the application with a pending payment status.
5. The backend creates a Razorpay order using the configured registration fee.
6. Razorpay Checkout opens for the applicant.
7. The applicant completes the payment.
8. The backend verifies the Razorpay payment signature.
9. The application payment status is updated after successful verification.
10. The applicant receives a registration confirmation.

Payment status should be treated as confirmed only after server-side verification. A frontend success callback alone is not sufficient.

## 💳 Razorpay Integration

### Required Environment Variables

Create a `.env.local` file in the project root:

```env
RAZORPAY_KEY_ID=your_razorpay_key_id
RAZORPAY_KEY_SECRET=your_razorpay_key_secret
NEXT_PUBLIC_RAZORPAY_KEY_ID=your_razorpay_key_id

DATABASE_URL=your_database_connection_string
```

Use only the environment variables required by your implementation. The public key ID may be exposed to the frontend; the secret key must remain server-side.

Never commit `.env.local` or other files containing secrets to GitHub.

### Suggested API Endpoints

| Endpoint | Method | Purpose |
|---|---|---|
| `/api/register` | POST | Validate and save applicant information |
| `/api/payment/create-order` | POST | Create a Razorpay order |
| `/api/payment/verify` | POST | Verify payment signature |
| `/api/payment/webhook` | POST | Process verified Razorpay webhook events |

These endpoints are a suggested structure and must be implemented in the application.

## 🚀 Installation and Setup

### Prerequisites

- Node.js and npm installed
- Razorpay account with API credentials
- Database configured for applicant records
- Git installed (optional)

### Step 1: Clone the Repository

```bash
git clone <your-repository-url>
cd <your-project-folder>
```

### Step 2: Install Dependencies

```bash
npm install
```

For a Next.js application using Razorpay's Node.js SDK:

```bash
npm install razorpay
```

Install any additional database, validation, and upload dependencies required by the project.

### Step 3: Configure Environment Variables

Create `.env.local` and add the required Razorpay credentials and database configuration.

### Step 4: Start the Development Server

```bash
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) in your browser.

### Step 5: Test the Payment Flow

- Use Razorpay Test Mode credentials during development.
- Submit a test registration.
- Complete a test payment using the payment methods supported by the test environment.
- Verify payment signature handling and database updates.
- Test unsuccessful payments, repeated submissions, and webhook processing.
- Switch to Live Mode only after successful testing and production configuration.

## 🔐 Security Considerations

- Keep Razorpay secret keys on the server.
- Calculate the payable amount on the backend instead of trusting a client-provided amount.
- Verify payment signatures using the official Razorpay procedure.
- Validate and sanitize all applicant input.
- Restrict uploaded file types and sizes.
- Store uploaded photographs in controlled storage.
- Protect applicant personal information from unauthorized access.
- Verify webhook signatures against the raw request body.
- Use idempotent payment processing to avoid duplicate updates.
- Use HTTPS in production.
- Follow applicable privacy, data-retention, and payment compliance requirements.

## 📁 Suggested Project Structure

```text
mahashankh-fashion-registration/
├── app/
│   ├── page.tsx
│   ├── register/
│   │   └── page.tsx
│   └── api/
│       ├── register/
│       │   └── route.ts
│       └── payment/
│           ├── create-order/
│           │   └── route.ts
│           ├── verify/
│           │   └── route.ts
│           └── webhook/
│               └── route.ts
├── components/
│   ├── ModelRegistrationForm.tsx
│   └── PaymentCheckout.tsx
├── lib/
│   ├── razorpay.ts
│   ├── database.ts
│   └── validation.ts
├── public/
│   └── images/
├── .env.local
├── .gitignore
├── package.json
└── README.md
```

This structure is an example for a Next.js App Router implementation; adjust it to match the actual repository.

## 📋 Future Enhancements

- Admin dashboard for reviewing model applications.
- Email and SMS registration confirmations.
- Application approval and rejection workflow.
- Audition and casting schedule management.
- Downloadable registration receipts.
- Automated payment reconciliation.
- Model portfolio gallery.
- Search, filtering, and applicant status reports.
- Secure applicant login and profile management.

## 📄 License

Specify the applicable license before distributing or publishing this project.

## 👗 About Mahashankh

Mahashankh Fashion Model Registration is intended to provide an accessible online platform for aspiring models to submit applications and complete registration payments through a structured digital process.

**Project:** Mahashankh Fashion Model Registration Form  
**Payment Gateway:** Razorpay  
**Purpose:** Online model registration and payment management
