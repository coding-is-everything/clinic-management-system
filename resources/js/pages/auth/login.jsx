import { Head } from '@inertiajs/react';
import { BriefcaseMedical } from 'lucide-react';
import AuthFooterLinks from '@/components/auth/auth-footer-links';
import LoginBrandingPanel from '@/components/auth/login-branding-panel';
import LoginCard from '@/components/auth/login-card';
import PasskeyVerify from '@/components/passkey-verify';
import TeamInvitationAlert from '@/components/team-invitation-alert';

export default function Login({ status, canResetPassword, teamInvitation }) {
    return (
        <div className="flex min-h-screen flex-col bg-background text-foreground antialiased md:flex-row">
            <Head title="Log in" />

            <LoginBrandingPanel />

            <div className="flex w-full flex-col md:w-1/2">
                <div className="flex flex-1 flex-col items-center justify-center p-4 sm:p-6 md:p-8">
                    <div className="mb-8 flex w-full items-center justify-center gap-2 md:hidden">
                        <BriefcaseMedical className="size-8 text-clinical-teal" />
                        <span className="font-heading text-headline-lg font-bold text-medical-blue">
                            ClinicOS
                        </span>
                    </div>

                    <div className="w-full max-w-md space-y-6">
                        {teamInvitation && (
                            <TeamInvitationAlert
                                invitation={teamInvitation}
                                action="Log in"
                            />
                        )}

                        <PasskeyVerify />

                        <LoginCard
                            canResetPassword={canResetPassword}
                            status={status}
                        />
                    </div>
                </div>

                <AuthFooterLinks />
            </div>
        </div>
    );
}
