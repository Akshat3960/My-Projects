# AI Room Booking Chatbot

This project demonstrates a virtual assistant built using IBM Watson Assistant and integrated with IBM Cloud Functions for automated email notifications. The chatbot is designed to simulate a hotel room booking assistant that can interact with users naturally, provide helpful information, and handle booking requests.


## Features          
Conversational Interface: The assistant can handle greetings, booking requests, help messages, and cancellations.

Room Booking: Users can book rooms by providing date, time, and phone number.

Hotel Info: Provides hotel location, directions from landmarks (e.g., Mahatma Gandhi Statue, Chennai Lighthouse), and hours of operation.

Holiday Awareness: Recognizes holidays like Christmas, New Year's, and provides open/closed status accordingly.

Natural Language Understanding:

Detects user intents such as Room_Bookings, Hotel_Hours, Hotel_Location, Help, Cancel, Thanks, General_Greetings, and Goodbye.

Extracts entities such as sys-date, sys-time, phone, holiday, landmark, and zip_code.

Email Notifications: On successful booking, it triggers an IBM Cloud Function (IBM_Cloud_Function.py) that sends a formatted email to notify hotel staff with the booking details.

## Tech Stack
IBM Watson Assistant: For building the conversational AI skill (skill-Room-Booking.json).

IBM Cloud Functions (OpenWhisk): Serverless backend to send booking emails.

SMTP (via Gmail): Sends email notifications securely.

## Project Files
skill-Room-Booking.json: The chatbot skill definition containing intents, entities, dialog nodes, and sample utterances.

IBM_Cloud_Function.py: Python script used as a cloud function to send booking notifications via email.

demo.gif: A screen recording of the chatbot in action on a mobile device.

## How it Works
The user initiates conversation (e.g., "Hi", "Book a room", etc.).

The assistant gathers booking details like date, time, and phone number.

Once confirmed, these details are sent to a webhook.

The webhook triggers the IBM_Cloud_Function.py, which sends a booking notification email to hotel staff.

The user receives confirmation or is prompted again based on intent classification.

## Setup Instructions
Import the Skill:

Go to IBM Watson Assistant and create a new assistant.

Import skill-Room-Booking.json into the assistant.

Deploy the Cloud Function:

Deploy IBM_Cloud_Function.py to IBM Cloud Functions.

Replace the placeholders in the code (sender email, receiver email, sender password) with your own credentials.

Ensure SMTP access is enabled for your Gmail account (consider using App Passwords for security).

Link Webhook in Watson:

Add your IBM Cloud Function URL in the webhook section of the Watson skill (main_webhook).

## Test the Bot:

Launch the Assistant preview and interact with your chatbot. Use demo.gif as a guide to expected behavior.

## Security Notes
Do not hardcode email credentials in production. Use IBM Cloud Secrets Manager or environment variables.

Use App Passwords for Gmail (not your actual account password).

## Future Enhancements
Add payment integration.

Support multi-language conversation.

Integrate with real-time room availability databases.

Expand to support multi-room or group bookings.



