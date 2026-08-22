import LoginForm from '@/components/auth/login-form';

export default function LoginCard({ canResetPassword, status }) {
    return (
        <div className="w-full max-w-md rounded-lg border border-border bg-white p-8 shadow-[0px_4px_12px_rgba(15,23,42,0.08)]">
            <div className="mb-6">
                <h2 className="mb-1 font-heading text-headline-md text-foreground">
                    Sign In
                </h2>
                <p className="text-body-md text-muted-foreground">
                    Access your clinical dashboard securely.
                </p>
            </div>

            {status && (
                <p className="mb-6 text-body-md font-medium text-clinical-teal">
                    {status}
                </p>
            )}

            <LoginForm canResetPassword={canResetPassword} />

            <div className="mt-6 border-t border-border pt-4 text-center">
                <p className="text-body-md text-muted-foreground">
                    Need support?{' '}
                    <a
                        className="text-clinical-teal hover:underline"
                        href="#"
                    >
                        Contact IT Helpdesk
                    </a>
                </p>
            </div>
        </div>
    );
}
