import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, CircleCheck, Clock } from 'lucide-react';
import { show } from '@/routes/onboarding';
import OnboardingSidePanel from '@/components/onboarding/onboarding-side-panel';
import OnboardingStepIndicator from '@/components/onboarding/onboarding-step-indicator';

const CLINIC_TYPE_LABELS = {
    general: 'General Practice',
    dental: 'Dental',
    physio: 'Physiotherapy',
    specialist: 'Specialist / Multi-specialty',
    other: 'Other',
};

const SUMMARY_ROWS = [
    ['organization_name', 'Organization'],
    ['workspace_slug', 'Workspace'],
    ['business_email', 'Business Email'],
    ['phone', 'Phone'],
    ['clinic_type', 'Clinic Type'],
    ['num_doctors', 'Doctors'],
    ['num_branches', 'Branches'],
];

export default function OnboardingSetupPending({ organization, appHost }) {
    return (
        <div className="flex min-h-screen flex-col bg-white text-foreground antialiased md:flex-row">
            <Head title="Workspace setup" />

            <OnboardingSidePanel />

            <div className="flex h-full flex-1 flex-col overflow-y-auto">
                <div className="mx-auto flex w-full max-w-[640px] flex-1 flex-col justify-center px-6 py-10 sm:px-10 lg:px-16">
                    <OnboardingStepIndicator
                        step={2}
                        totalSteps={4}
                        label="Admin Account & Team Setup"
                    />

                    <div className="mb-6 flex items-start gap-3 rounded-lg border border-border bg-muted p-4">
                        <Clock className="mt-0.5 size-5 shrink-0 text-clinical-teal" />
                        <div>
                            <h1 className="mb-1 font-heading text-headline-md text-foreground">
                                Your organization details are saved
                            </h1>
                            <p className="text-body-md text-muted-foreground">
                                Account and billing setup for this step is
                                coming soon. We&apos;ve held onto everything
                                you entered so you won&apos;t need to redo it.
                            </p>
                        </div>
                    </div>

                    <div className="mb-8 overflow-hidden rounded-lg border border-border">
                        {SUMMARY_ROWS.map(([key, label], index) => {
                            const value = organization?.[key];

                            if (!value) return null;

                            return (
                                <div
                                    key={key}
                                    className={`flex items-center justify-between px-4 py-3 text-body-md ${
                                        index !== 0
                                            ? 'border-t border-border'
                                            : ''
                                    }`}
                                >
                                    <span className="text-muted-foreground">
                                        {label}
                                    </span>
                                    <span className="flex items-center gap-2 font-medium text-foreground">
                                        <CircleCheck className="size-4 text-clinical-teal" />
                                        {key === 'clinic_type'
                                            ? (CLINIC_TYPE_LABELS[value] ??
                                              value)
                                            : key === 'workspace_slug'
                                              ? `${appHost}/${value}/dashboard`
                                              : value}
                                    </span>
                                </div>
                            );
                        })}
                    </div>

                    <Link
                        href={show()}
                        className="inline-flex w-fit items-center gap-1 text-label-md text-clinical-teal transition-colors hover:text-clinical-teal-dark"
                    >
                        <ArrowLeft className="size-4" />
                        Back to Organization Details
                    </Link>
                </div>
            </div>
        </div>
    );
}
