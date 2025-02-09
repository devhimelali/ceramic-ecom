<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'subject' => 'Inquiry about services',
                'message' => 'I would like to know more about your services. Please provide more details.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'subject' => 'Feedback on recent purchase',
                'message' => 'I recently purchased an item from your store, and I wanted to provide some feedback on the experience.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'subject' => 'Support Request',
                'message' => 'I am facing an issue with my account login and need assistance.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
                'subject' => 'Payment Issue',
                'message' => 'I encountered a problem with my payment, and I need help resolving it.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mary Lee',
                'email' => 'mary.lee@example.com',
                'subject' => 'Shipping Inquiry',
                'message' => 'I would like to know the status of my shipment and when I can expect delivery.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'James Miller',
                'email' => 'james.miller@example.com',
                'subject' => 'Product Availability',
                'message' => 'Is the product X still available for purchase on your website?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Linda Garcia',
                'email' => 'linda.garcia@example.com',
                'subject' => 'Website Feedback',
                'message' => 'I think your website could be improved in terms of navigation and layout.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Davis',
                'email' => 'michael.davis@example.com',
                'subject' => 'Account Support',
                'message' => 'I am unable to access my account. Can you assist me with resetting my password?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah White',
                'email' => 'sarah.white@example.com',
                'subject' => 'Order Cancellation',
                'message' => 'I need to cancel my recent order due to unforeseen circumstances.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Harris',
                'email' => 'david.harris@example.com',
                'subject' => 'Warranty Inquiry',
                'message' => 'I would like to inquire about the warranty period for product Y.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Elizabeth Clark',
                'email' => 'elizabeth.clark@example.com',
                'subject' => 'Return Policy',
                'message' => 'Can you clarify your return policy for items purchased online?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Richard Lewis',
                'email' => 'richard.lewis@example.com',
                'subject' => 'Product Defect',
                'message' => 'I have noticed a defect in the product I received and would like a replacement.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patricia Walker',
                'email' => 'patricia.walker@example.com',
                'subject' => 'Job Application',
                'message' => 'I am interested in applying for a position at your company. Please find my resume attached.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Steven Hall',
                'email' => 'steven.hall@example.com',
                'subject' => 'Feedback on Customer Service',
                'message' => 'I wanted to provide feedback regarding my recent experience with your customer service team.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nancy Allen',
                'email' => 'nancy.allen@example.com',
                'subject' => 'Service Inquiry',
                'message' => 'I am interested in your consulting services and would like to know more about what you offer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Joseph King',
                'email' => 'joseph.king@example.com',
                'subject' => 'Discount Request',
                'message' => 'Are there any discounts available for first-time customers?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deborah Scott',
                'email' => 'deborah.scott@example.com',
                'subject' => 'Technical Issue',
                'message' => 'I am encountering a technical issue with your website and cannot complete my purchase.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kevin Young',
                'email' => 'kevin.young@example.com',
                'subject' => 'Account Verification',
                'message' => 'Can you verify my account details so that I can complete my registration?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rebecca Hernandez',
                'email' => 'rebecca.hernandez@example.com',
                'subject' => 'Product Information',
                'message' => 'Could you provide more information about the features of product Z?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gary Lee',
                'email' => 'gary.lee@example.com',
                'subject' => 'Order Status',
                'message' => 'Can you update me on the status of my recent order?',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($contacts as $contact) {
            ContactUs::create($contact);
        }
    }
}
