import { Form, Head, Link } from '@inertiajs/react';
import { ArrowRight, BriefcaseMedical, ChevronDown } from 'lucide-react';
import { useState } from 'react';
import { store } from '@/routes/onboarding';
import OnboardingSidePanel from '@/components/onboarding/onboarding-side-panel';
import OnboardingStepIndicator from '@/components/onboarding/onboarding-step-indicator';

const CLINIC_TYPES = [
    { value: 'general', label: 'General Practice' },
    { value: 'dental', label: 'Dental' },
    { value: 'physio', label: 'Physiotherapy' },
    { value: 'specialist', label: 'Specialist / Multi-specialty' },
    { value: 'other', label: 'Other' },
];

const inputClasses =
    'block h-10 w-full rounded-lg border border-border bg-white px-3 text-body-md text-foreground transition-colors focus:border-clinical-teal focus:ring-2 focus:ring-clinical-teal/10 focus:outline-none';
const labelClasses = 'mb-1 block text-label-md text-muted-foreground';

export default function OnboardingOrganization({ organization, appHost }) {
    const [slugPreview, setSlugPreview] = useState(
        organization?.workspace_slug ?? '',
    );

    return (
        <div className="flex min-h-screen flex-col bg-white text-foreground antialiased md:flex-row">
            <Head title="Create your workspace" />

            <OnboardingSidePanel />

            <div className="flex h-full flex-1 flex-col overflow-y-auto">
                <div className="flex items-center gap-2 border-b border-border p-6 md:hidden">
                    <BriefcaseMedical className="size-6 text-clinical-teal" />
                    <span className="font-heading text-headline-md font-bold text-medical-blue">
                        ClinicOS
                    </span>
                </div>

                <div className="mx-auto flex w-full max-w-[800px] flex-1 flex-col justify-center px-6 py-10 sm:px-10 lg:px-16">
                    <OnboardingStepIndicator
                        step={1}
                        totalSteps={4}
                        label="Organization Details"
                    />

                    <div className="mb-8">
                        <h1 className="mb-1 font-heading text-headline-lg text-foreground">
                            Create your ClinicOS workspace
                        </h1>
                        <p className="text-body-lg text-muted-foreground">
                            Set up your clinic in a few minutes.
                        </p>
                    </div>

                    <Form
                        {...store.form()}
                        disableWhileProcessing
                        className="space-y-6"
                    >
                        {({ processing, errors }) => (
                            <>
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label
                                            htmlFor="organization_name"
                                            className={labelClasses}
                                        >
                                            Organization Name
                                        </label>
                                        <input
                                            id="organization_name"
                                            name="organization_name"
                                            type="text"
                                            required
                                            autoFocus
                                            defaultValue={
                                                organization?.organization_name ??
                                                ''
                                            }
                                            placeholder="e.g. Sunrise Healthcare"
                                            className={inputClasses}
                                        />
                                        {errors.organization_name && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.organization_name}
                                            </p>
                                        )}
                                    </div>

                                    <div>
                                        <label
                                            htmlFor="workspace_slug"
                                            className={labelClasses}
                                        >
                                            Workspace Slug
                                        </label>
                                        <input
                                            id="workspace_slug"
                                            name="workspace_slug"
                                            type="text"
                                            required
                                            defaultValue={
                                                organization?.workspace_slug ??
                                                ''
                                            }
                                            onChange={(event) =>
                                                setSlugPreview(
                                                    event.target.value,
                                                )
                                            }
                                            placeholder="sunrise-healthcare"
                                            className={inputClasses}
                                        />
                                        <p className="mt-1 truncate text-sm text-muted-foreground">
                                            {appHost}/
                                            {slugPreview || 'sunrise-healthcare'}
                                            /dashboard
                                        </p>
                                        {errors.workspace_slug && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.workspace_slug}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label
                                            htmlFor="business_email"
                                            className={labelClasses}
                                        >
                                            Business Email
                                        </label>
                                        <input
                                            id="business_email"
                                            name="business_email"
                                            type="email"
                                            required
                                            defaultValue={
                                                organization?.business_email ??
                                                ''
                                            }
                                            placeholder="admin@sunrise.com"
                                            className={inputClasses}
                                        />
                                        {errors.business_email && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.business_email}
                                            </p>
                                        )}
                                    </div>

                                    <div>
                                        <label
                                            htmlFor="phone"
                                            className={labelClasses}
                                        >
                                            Phone
                                        </label>
                                        <input
                                            id="phone"
                                            name="phone"
                                            type="tel"
                                            required
                                            defaultValue={
                                                organization?.phone ?? ''
                                            }
                                            placeholder="+1 (555) 000-0000"
                                            className={inputClasses}
                                        />
                                        {errors.phone && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.phone}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        htmlFor="clinic_type"
                                        className={labelClasses}
                                    >
                                        Clinic Type
                                    </label>
                                    <div className="relative">
                                        <select
                                            id="clinic_type"
                                            name="clinic_type"
                                            required
                                            defaultValue={
                                                organization?.clinic_type ?? ''
                                            }
                                            className={
                                                inputClasses +
                                                ' cursor-pointer appearance-none pr-10'
                                            }
                                        >
                                            <option value="" disabled>
                                                Select a specialty…
                                            </option>
                                            {CLINIC_TYPES.map((type) => (
                                                <option
                                                    key={type.value}
                                                    value={type.value}
                                                >
                                                    {type.label}
                                                </option>
                                            ))}
                                        </select>
                                        <ChevronDown className="pointer-events-none absolute top-1/2 right-3 size-4 -translate-y-1/2 text-muted-foreground" />
                                    </div>
                                    {errors.clinic_type && (
                                        <p className="mt-1 text-sm text-destructive">
                                            {errors.clinic_type}
                                        </p>
                                    )}
                                </div>

                                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label
                                            htmlFor="num_doctors"
                                            className={labelClasses}
                                        >
                                            Number of Doctors
                                        </label>
                                        <input
                                            id="num_doctors"
                                            name="num_doctors"
                                            type="number"
                                            min="1"
                                            defaultValue={
                                                organization?.num_doctors ?? ''
                                            }
                                            placeholder="e.g. 5"
                                            className={inputClasses}
                                        />
                                        {errors.num_doctors && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.num_doctors}
                                            </p>
                                        )}
                                    </div>

                                    <div>
                                        <label
                                            htmlFor="num_branches"
                                            className={labelClasses}
                                        >
                                            Number of Branches
                                        </label>
                                        <input
                                            id="num_branches"
                                            name="num_branches"
                                            type="number"
                                            min="1"
                                            defaultValue={
                                                organization?.num_branches ??
                                                ''
                                            }
                                            placeholder="e.g. 2"
                                            className={inputClasses}
                                        />
                                        {errors.num_branches && (
                                            <p className="mt-1 text-sm text-destructive">
                                                {errors.num_branches}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div className="mt-8 flex items-center justify-between border-t border-border pt-6">
                                    <Link
                                        href="/login"
                                        className="text-label-md text-muted-foreground transition-colors hover:text-foreground"
                                    >
                                        Cancel
                                    </Link>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="group inline-flex h-10 items-center justify-center gap-1 rounded-lg bg-clinical-teal px-4 text-label-md text-white shadow-sm transition-colors hover:bg-clinical-teal-dark disabled:cursor-not-allowed disabled:opacity-70"
                                    >
                                        Continue to Setup
                                        <ArrowRight className="size-[18px] transition-transform group-hover:translate-x-1" />
                                    </button>
                                </div>
                            </>
                        )}
                    </Form>
                </div>
            </div>
        </div>
    );
}
