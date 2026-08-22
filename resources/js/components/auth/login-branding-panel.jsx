import { BriefcaseMedical } from 'lucide-react';

export default function LoginBrandingPanel() {
    return (
        <div className="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-medical-blue p-8 text-white md:flex">
            <div
                className="absolute inset-0 z-0 opacity-50"
                style={{
                    backgroundImage:
                        'radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px)',
                    backgroundSize: '24px 24px',
                }}
            />

            <div className="relative z-10">
                <div className="mb-6 flex items-center gap-2">
                    <BriefcaseMedical
                        className="size-9 text-clinical-teal"
                        strokeWidth={2}
                    />
                    <span className="font-heading text-headline-lg font-bold tracking-tight">
                        ClinicOS
                    </span>
                </div>
                <h1 className="mt-24 max-w-md font-heading text-display-lg">
                    Complete OPD Management for Modern Clinics
                </h1>
                <p className="mt-2 max-w-md text-body-lg text-white/90">
                    Secure, efficient, and precise clinical workflows tailored
                    for high-stakes healthcare environments.
                </p>
            </div>

            <div className="relative z-10 text-label-md text-white/80">
                © {new Date().getFullYear()} ClinicOS. Clinical Precision
                System.
            </div>
        </div>
    );
}
