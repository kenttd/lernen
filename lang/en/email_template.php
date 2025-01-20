<?php

return [

    /*
    |--------------------------------------------------------------------------
    | All Translation Lines For Email Templates
    |--------------------------------------------------------------------------
    */

    'email_templates'                           => 'Email Templates',
    'all_templates'                             => 'All Email Templates',
    'select_template'                           => 'Select Template',
    'set_email_status'                          => 'Set email status as',
    'add_email_template'                        => 'Add new template',
    'update_email_template'                     => 'Update email template',
    'email_title'                               => 'Email title',
    'role_type'                                 => 'Role type',
    'approve_instructor'                        => 'Approve Instructor',
    'select_template'                           => 'Select template',
    'student'                                   => 'Student',
    'tutor'                                     => 'Tutor',
    'btn_invite'                                => 'Accept Invitation',
    'admin'                                     => 'Admin',
    'verfiy_email'                              => 'Verify Email Address',
    'login_url'                                 => '“Login”',
    'ridirect_login'                            => 'Redict to login',
    'reset_password_txt'                        => 'Reset password',
    'email_setting_variable'                    => 'Email setting variables',
    'greeting_text'                             => 'Greeting text',
    'email_content'                             => 'Email content',
    'subject'                                   => 'Email subject',

    // =========== Email general translation ==================== \\
    'email_content'                                     => 'Email Content',
    'registration_title'                                => 'Registration Email',
    'email_verification_title'                          => 'Email Verification',
    'password_reset_title'                              => 'Password Reset Request',
    'identity_verification_request_title'               => 'Identity Verification Request',
    'identity_verification_approved_title'              => 'Identity Verification Approved',
    'identity_verification_rejected_title'              => 'Identity Verification Rejected',
    'session_booking_title'                             => 'Session Booking',
    'booking_rescheduled_title'                         => 'Booking Rescheduled',
    'withdraw_wallet_amount_request_title'              => 'Withdraw Wallet Amount Request',
    'accepted_withdraw_request_title'                   => 'Accepted Withdraw Request',
    'new_message_notification_title'                    => 'New Message Notification',
    'invite_user_title'                                 => 'Invite User',
    'booking_link_title'                                => 'Meeting Link for Your Upcoming Session',
    'session_request_title'                             => 'Session Request',
    'booking_completion_request_title'                  => 'Booking Completion Request',


    'variables_used'                                    => 'Variables Used in email',
    'subject'                                           => 'Subject',

    'registration_student_subject'                      => 'Welcome to Lernen, {userName}!',
    'registration_tutor_subject'                        => 'Welcome to Lernen, {userName}!',
    'registration_admin_subject'                        => 'New User Registration Notification',
    'greeting'                                          => 'Dear :userName,',
    'greeting_admin'                                    => 'Dear Admin,',

    'registration_student_content'                      => 'We are excited to have you join the Lernen community, :userName! Please verify your email address by clicking the following link: :verificationLink We are looking forward to seeing you thrive and achieve your learning goals.',
    'registration_tutor_content'                        => 'We are thrilled to welcome you as a tutor on Lernen, :userName! To complete your registration, please verify your email address by clicking the following link: :verificationLink We are excited to see the positive impact you will make on your students\' learning journeys.',
    'registration_admin_content'                        => ':userName has registered with the email :userEmail. Please verify their details and ensure they have a great experience on our platform.',

    'email_verification_subject'                        => 'Verify Your Email Address, :userName!',
    'email_verification_content'                        => 'Please verify your email address to complete your registration. Click the following link: :verificationLink We are eager to have you start your learning journey with us.',

    'password_reset_subject'                            => 'Password Reset Request',
    'password_reset_content'                            => 'We received a request to reset your password. If you made this request, please click the following link to reset your password: :resetLink If you did not request a password reset, please ignore this email.',

    'identity_verification_request_subject'             => 'Identity Verification Required',
    'identity_verification_request_content'             => 'Thank you for submitting your identity verification request on the Lernen platform. Our admin team will review your information shortly.<br> Name: {userName} <br> Role: {userRole} <br> Email: {userEmail} <br> Date of Request: {requestDate} <br> You will receive a confirmation email once your identity is verified. If we need any additional details, we will reach out to you directly.',
    'identity_verification_request_admin_subject'       => 'New Identity Verification Request',
    'identity_verification_request_admin_content'       => 'A new identity verification request has been submitted on the Lernen platform. Please find the details of the user below: <br> Name: {userName} <br> Role: {userRole} <br> Email: {userEmail} <br> Date of Request: {requestDate} <br> Please proceed with the necessary steps to verify the identity of this user.',

    'identity_verification_approved_subject'            => 'Identity Verification Approved',
    'identity_verification_approved_content'            => 'Congratulations, :userName! Your identity has been successfully verified. You can now fully enjoy all the benefits of our platform. Thank you for your cooperation.',

    'identity_verification_rejected_subject'            => 'Identity Verification Rejected',
    'identity_verification_rejected_content'            => 'We regret to inform you, :userName, that your identity verification has been rejected. Reason: :rejectionReason. Please provide the required documents and try again. If you have any questions, feel free to contact our support team.',

    'session_booking_student_subject'                   => 'Thank you for booking with Lernen!',
    'session_booking_student_content'                   => 'We’re excited to confirm your upcoming sessions. Here are the details for each of your bookings <br> :bookingDetails <br> Thanks for choosing Lernen! We’re here to help you reach your learning goals.',
    'session_booking_tutor_subject'                     => 'Thank you for booking with Lernen!',
    'session_booking_tutor_content'                     => 'We’re excited to confirm your upcoming sessions. Here are the details for each of your bookings <br> :bookingDetails <br> Thanks for choosing Lernen! We’re here to help you reach your learning goals.',

    'booking_rescheduled_subject'                       => 'Your Session Has Been Rescheduled',
    'booking_rescheduled_content'                       => 'We wanted to let you know that your session with :tutorName has been rescheduled to :newSessionDate due to the following reason: <br /> :reason. You can view further details by clicking the following link :viewLink We apologize for any inconvenience and appreciate your understanding.',

    'withdraw_wallet_amount_request_subject'            => 'Withdraw Wallet Amount Request',
    'withdraw_wallet_amount_request_content'            => ':userName has requested to withdraw :withdrawAmount from their wallet. Please review and process the request at your earliest convenience.',

    'accepted_withdraw_request_subject'                 => 'Your Withdraw Request Has Been Approved',
    'accepted_withdraw_request_content'                 => 'Good news, :userName! Your request to withdraw :withdrawAmount from your wallet has been approved. The amount will be credited to your account shortly. Thank you for being a valued member of the Lernen community.',

    'new_message_subject'                               => 'New Message from :messageSender',
    'new_message_content'                               => 'You have received a new message from :messageSender. Please log in to your account to respond.',
    
    'meeting_link_subject'                              => 'Meeting Link for Your Upcoming Session',
    'meeting_link_content'                              => 'I hope this message finds you well. We wanted to let you know that your tutor has updated the meeting link for your upcoming session. Please make sure to use the new link when joining.<br /> The session is scheduled for <strong>{sessionDate}</strong> and covers <strong>{sessionSubject}</strong>. The updated meeting link is provided here: {meetingLink} Kindly use this link to join your session at the scheduled time.',
    
    'booking_completion_request_subject'               => 'Confirm Your Session with {tutorName}',
    'booking_completion_request_content'               => 'Your session with {tutorName} for date {sessionDateTime} has been completed. Please confirm if the session was satisfactory or it will be marked as completed by the system automatically after {days} days. <br> {completeBookingLink}',

    'invite_user_subject'                               => 'Invite User',

    'registration_student_variables'                    => '{userName} - For Username <br> {userEmail} - For User email <br> {verificationLink} - For Verification Link',
    'registration_tutor_variables'                      => '{userName} - For Username <br> {userEmail} - For User email <br> {verificationLink} - For Verification Link',
    'registration_admin_variables'                      => '{userName} - For Username <br> {userEmail} - For User email',

    'email_verification_student_variables'              => '{userName} - For Username <br> {verificationLink} - For Verification Link',
    'email_verification_tutor_variables'                => '{userName} - For Username <br> {verificationLink} - For Verification Link',

    'password_reset_student_variables'                  => '{userName} - For Username <br> {resetLink} - For Password Reset Link',
    'password_reset_tutor_variables'                    => '{userName} - For Username <br> {resetLink} - For Password Reset Link',
    'identity_verification_request_variables'           => '{userName} - For Username <br> {userEmail} - For User email <br> {userRole} - For User role <br> {requestDate} - For User request date',

    'identity_verification_approved_student_variables'  => '{userName} - For Username',
    'identity_verification_approved_tutor_variables'    => '{userName} - For Username',

    'identity_verification_rejected_student_variables'  => '{userName} - For Username <br> {rejectionReason} - For Rejection Reason',
    'identity_verification_rejected_tutor_variables'    => '{userName} - For Username <br> {rejectionReason} - For Rejection Reason',

    'session_booking_student_variables'                 => '{userName} - For Username <br> {sessionDate} - For Session Date <br> {tutorName} - For Tutor Name <br> {sessionSubject} - For Session Subject <br> {bookingDetails} - For Details of Bookings',
    'session_booking_tutor_variables'                   => '{userName} - For Username <br> {sessionDate} - For Session Date <br> {studentName} - For Student Name <br> {sessionSubject} - For Session Subject <br> {bookingDetails} - For Details of Bookings',

    'booking_rescheduled_student_variables'             => '{userName} - For Username <br> {newSessionDate} - For New Session Date <br> {tutorName} - For Tutor Name <br> {viewLink} - For viewing detail',

    'withdraw_wallet_amount_request_admin_variables'    => '{userName} - For Username <br> {withdrawAmount} - For Withdraw Amount',

    'accepted_withdraw_request_tutor_variables'         => '{userName} - For Username <br> {withdrawAmount} - For Withdraw Amount',

    'accepted_withdraw_request_tutor_variables'         => '{userName} - For Username <br> {withdrawAmount} - For Withdraw Amount',
    
    'booking_completion_request_student_variables'      => '{userName} - For Username <br> {tutorName} - For Tutor Name <br> {sessionDateTime} - For Session Date & Time <br> {completeBookingLink} - For Complete Booking Link <br> {days} - For Days',

    'new_message_student_variables'                     => '{userName} - For Username <br> {messageSender} - For Message Sender',
    'new_message_tutor_variables'                       => '{userName} - For Username <br> {messageSender} - For Message Sender',

    'meeting_link_student_variables'                    => '{userName} - For Username <br> {sessionDate} - For Session Date <br> {tutorName} - For Tutor Name <br> {sessionSubject} - For Session Subject <br> {meetingLink} - For Meeting Link',
    'session_request_student_variables'                 => '{userName} - For Username <br> {studentName} - For Student Name <br> {studentEmail} - For Student Email <br> {sessionType} - For Session Type <br> {message} - For Message',
    'session_request_admin_variables'                   => '{userName} - For Username <br> {studentName} - For Student Name <br> {studentEmail} - For Student Email <br> {sessionType} - For Session Type <br> {message} - For Message',
    'session_request_subject'                           => 'New Custom Session Request from {studentName}',
    'session_request_content'                           => 'You have received a new session request from a student. Here are the details:<br /> <br /> <strong> Student Name </strong>: {studentName}<br /><strong> Student Email </strong>: {studentEmail}<br ><strong> Session Type </strong>: {sessionType}<br /><strong> Message </strong>: {message}',
    'session_request_greeting_admin'                    => 'Hi Admin,',
    'session_request_subject_admin'                     => 'New Custom Session Request Submitted by {studentName}',
    'session_request_content_admin'                     => 'A new custom session request has been submitted by a student. Below are the details:<br /> <br /> <strong> Student Name </strong>: {studentName}<br /><strong> Student Email </strong>: {studentEmail}<br ><strong> Session Type </strong>: {sessionType}<br /><strong> Message </strong>: {message}',
    
];
