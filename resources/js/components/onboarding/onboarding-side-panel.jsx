import { BriefcaseMedical, Gauge, ShieldCheck } from 'lucide-react';

const HIGHLIGHTS = [
    {
        icon: ShieldCheck,
        title: 'HIPAA Compliant',
        description: 'Enterprise-grade security for your sensitive patient data.',
    },
    {
        icon: Gauge,
        title: 'Fast Setup',
        description: 'Get your entire team onboarded in minutes, not days.',
    },
];

export default function OnboardingSidePanel() {
    return (
        <div className="relative hidden flex-col justify-between overflow-hidden bg-medical-blue p-8 text-white md:flex md:w-[420px] lg:w-[480px]">
            <div className="relative z-10 flex flex-col gap-8">
                <div className="flex items-center gap-2 font-heading text-headline-md font-bold">
                    <BriefcaseMedical className="size-6 text-clinical-teal" />
                    ClinicOS
                </div>

                <div className="max-w-sm">
                    <h2 className="mb-3 font-heading text-headline-lg">
                        Modernizing Medical Management
                    </h2>
                    <p className="text-body-lg text-white/70">
                        Streamline your clinic&apos;s operations, patient
                        records, and billing with a secure, multi-tenant
                        platform built for healthcare teams.
                    </p>
                </div>

                <div className="flex flex-col gap-4">
                    {HIGHLIGHTS.map(({ icon: Icon, title, description }) => (
                        <div key={title} className="flex items-start gap-3">
                            <div className="shrink-0 rounded-lg bg-clinical-teal/20 p-2">
                                <Icon className="size-5 text-clinical-teal" />
                            </div>
                            <div>
                                <h4 className="mb-1 text-label-md font-semibold">
                                    {title}
                                </h4>
                                <p className="text-sm text-white/70">
                                    {description}
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}
