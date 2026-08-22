<?php

namespace App\Support;

class ClinicModules
{
    /**
     * The clinical operations modules shown in the sidebar, derived from the
     * ClinicOS database schema. Each module will eventually get its own
     * dedicated controller/pages; for now they render a shared placeholder.
     *
     * Deliberately excluded: platform/SaaS-level tables (tenants, plans,
     * subscriptions, integrations, etc.) — those belong to a separate
     * platform-admin area, not a single clinic's operational dashboard.
     *
     * @return array<int, array{key: string, title: string, icon: string, description: string, tables: array<int, string>}>
     */
    public static function all(): array
    {
        return [
            [
                'key' => 'clinics',
                'title' => 'Clinics & Branches',
                'icon' => 'Building2',
                'description' => 'Manage your clinic locations, branches, and operating configuration.',
                'tables' => ['clinics'],
            ],
            [
                'key' => 'front-desk',
                'title' => 'Front Desk',
                'icon' => 'CalendarClock',
                'description' => 'Manage appointment bookings, the walk-in queue, and doctor scheduling.',
                'tables' => [
                    'appointments', 'appointment_types', 'appointment_reschedules',
                    'appointment_waitlist', 'queue_entries', 'doctor_schedules',
                    'doctor_leaves', 'rooms',
                ],
            ],
            [
                'key' => 'patients',
                'title' => 'Patients',
                'icon' => 'Users',
                'description' => 'Patient records, medical history, allergies, and portal access.',
                'tables' => [
                    'patients', 'patient_conditions', 'patient_allergies',
                    'patient_medications', 'patient_documents', 'patient_portal_accounts',
                ],
            ],
            [
                'key' => 'clinical',
                'title' => 'Clinical',
                'icon' => 'Stethoscope',
                'description' => 'Consultation notes, vitals, diagnoses, and follow-up tracking.',
                'tables' => [
                    'encounters', 'encounter_vitals', 'encounter_complaints',
                    'encounter_examinations', 'diagnoses', 'encounter_diagnoses', 'followups',
                ],
            ],
            [
                'key' => 'pharmacy',
                'title' => 'Pharmacy',
                'icon' => 'Pill',
                'description' => 'Prescriptions, dispensing, and pharmacy point-of-sale.',
                'tables' => [
                    'medicines', 'prescriptions', 'prescription_items',
                    'medicine_batches', 'pharmacy_sales', 'pharmacy_sale_items',
                ],
            ],
            [
                'key' => 'inventory',
                'title' => 'Inventory',
                'icon' => 'Boxes',
                'description' => 'Stock levels, suppliers, and purchase orders.',
                'tables' => [
                    'suppliers', 'purchase_orders', 'goods_receipts',
                    'stock_movements', 'inventory_items', 'inventory_movements',
                ],
            ],
            [
                'key' => 'laboratory',
                'title' => 'Laboratory',
                'icon' => 'FlaskConical',
                'description' => 'Lab test orders, sample tracking, and results.',
                'tables' => [
                    'investigation_categories', 'investigations', 'investigation_orders',
                    'investigation_order_items', 'investigation_results',
                ],
            ],
            [
                'key' => 'billing',
                'title' => 'Billing',
                'icon' => 'Receipt',
                'description' => 'Invoices, payments, and refunds.',
                'tables' => [
                    'services', 'doctor_fees', 'invoices', 'invoice_items',
                    'payments', 'payment_allocations', 'refunds',
                ],
            ],
            [
                'key' => 'staff',
                'title' => 'Staff & Doctors',
                'icon' => 'IdCard',
                'description' => 'Doctor and staff profiles, specializations, and departments.',
                'tables' => ['doctors', 'staff', 'specializations', 'departments'],
            ],
            [
                'key' => 'reports',
                'title' => 'Reports',
                'icon' => 'BarChart3',
                'description' => 'Operational reports and activity audit trail.',
                'tables' => ['report_definitions', 'audit_logs', 'feature_usage'],
            ],
        ];
    }

    /**
     * @return array{key: string, title: string, icon: string, description: string, tables: array<int, string>}|null
     */
    public static function find(string $key): ?array
    {
        return collect(self::all())->firstWhere('key', $key);
    }

    /**
     * @return array<int, string>
     */
    public static function keys(): array
    {
        return array_column(self::all(), 'key');
    }
}
