<?php

namespace Database\Seeders;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setEmailTemplates();
    }

    public function setEmailTemplates(){
        EmailTemplate::truncate();
        $emailTemplates = $this->getEmailTemplates();
        $template_list  = [];

        foreach ($emailTemplates as $type => $template) {
            foreach ($template['roles'] as $role => $data) {
                EmailTemplate::firstOrCreate([
                    'type' => $type,
                    'title' => $template['title'],
                    'role' => $role,
                    'content' => ['info' => $data['fields']['info']['desc'],'subject' => $data['fields']['subject']['default'], 'greeting' => $data['fields']['greeting']['default'], 'content' => $data['fields']['content']['default']]
                ]);
            }
        }
        EmailTemplate::insert($template_list);
    }

    private function getEmailTemplates(){
       return
        [
            'registration' => [ //done & tested
                'title' => __('email_template.registration_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_student_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_student_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_tutor_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_tutor_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_admin_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_admin_content', ['userName' => '{userName}', 'userEmail' => '{userEmail}']),
                            ],
                        ],
                    ],
                ],
            ],
            'emailVerification' => [ //done & tested
                'title' => __('email_template.email_verification_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.email_verification_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.email_verification_subject', ['userName' => '{userName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.email_verification_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.email_verification_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.email_verification_subject', ['userName' => '{userName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.email_verification_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'passwordResetRequest' => [ //done & tested
                'title' => __('email_template.password_reset_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.password_reset_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.password_reset_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.password_reset_content', ['userName' => '{userName}', 'resetLink' => '{resetLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.password_reset_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.password_reset_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.password_reset_content', ['userName' => '{userName}', 'resetLink' => '{resetLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationRequest' => [ //done & tested
                'title' => __('email_template.identity_verification_request_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_content'),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_content'),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_admin_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_admin_content'),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationApproved' => [ //done & tested
                'title' => __('email_template.identity_verification_approved_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_approved_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_approved_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_approved_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_approved_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationRejected' => [ //done & tested
                'title' => __('email_template.identity_verification_rejected_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_rejected_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_rejected_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_rejected_content', ['userName' => '{userName}', 'rejectionReason' => '{rejectionReason}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_rejected_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_rejected_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_rejected_content', ['userName' => '{userName}', 'rejectionReason' => '{rejectionReason}']),
                            ],
                        ],
                    ],
                ],
            ],
            'sessionBooking' => [//implemented
                'title' => __('email_template.session_booking_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_booking_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_booking_student_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_booking_student_content', ['userName' => '{studentName}', 'tutorName' => '{tutorName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_booking_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_booking_tutor_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_booking_tutor_content', ['userName' => '{tutorName}', 'studentName' => '{studentName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingRescheduled' => [//implemented&tested
                'title' => __('email_template.booking_rescheduled_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.booking_rescheduled_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.booking_rescheduled_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.booking_rescheduled_content', ['userName' => '{userName}', 'tutorName' => '{tutorName}', 'newSessionDate' => '{newSessionDate}', 'reason' => '{reason}', 'viewLink' => '{viewLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'withdrawWalletAmountRequest' => [
                'title' => __('email_template.withdraw_wallet_amount_request_title'),
                'roles' => [
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.withdraw_wallet_amount_request_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.withdraw_wallet_amount_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.withdraw_wallet_amount_request_content', ['userName' => '{userName}', 'withdrawAmount' => '{withdrawAmount}']),
                            ],
                        ],
                    ],
                ],
            ],
            'acceptedWithdrawRequest' => [
                'title' => __('email_template.accepted_withdraw_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.accepted_withdraw_request_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.accepted_withdraw_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.accepted_withdraw_request_content', ['userName' => '{userName}', 'withdrawAmount' => '{withdrawAmount}']),
                            ],
                        ],
                    ],
                ],
            ],
            'newMessage' => [
                'title' => __('email_template.new_message_notification_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.new_message_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.new_message_content', ['userName' => '{userName}', 'messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.new_message_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.new_message_content', ['userName' => '{userName}', 'messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingLinkGenerated' => [
                'title' => __('email_template.booking_link_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.meeting_link_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.meeting_link_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.meeting_link_content'),
                            ],
                        ],
                    ],
                ]
            ],
            'bookingCompletionRequest' => [
                'title' => __('email_template.booking_completion_request_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.booking_completion_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.booking_completion_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.booking_completion_request_content'),
                            ],
                        ],
                    ],
                ]
            ],
            'sessionRequest' => [
                'title' => __('email_template.session_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_request_content', ['userName' => '{userName}', 'studentName' => '{studentName}', 'studentEmail' => '{studentEmail}', 'sessionType' => '{sessionType}', 'message' => '{message}']),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_request_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_request_content_admin', ['userName' => '{userName}', 'studentName' => '{studentName}', 'studentEmail' => '{studentEmail}', 'sessionType' => '{sessionType}', 'message' => '{message}']),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
