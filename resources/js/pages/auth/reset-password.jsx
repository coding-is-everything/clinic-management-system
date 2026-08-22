import { Form, Head } from '@inertiajs/react';
import { ArrowLeft, ArrowRight, Lock, ShieldCheck } from 'lucide-react';
import { useState } from 'react';
import PasswordField from '@/components/auth/password-field';
import PasswordRequirements, {
    passwordMeetsRequirements,
} from '@/components/auth/password-requirements';
import { update } from '@/routes/password';

export default function ResetPassword({ token, email }) {
    const [password, setPassword] = useState('');
    const [confirmation, setConfirmation] = useState('');

    const requirementsMet = passwordMeetsRequirements(password);
    const passwordsMatch = confirmation.length === 0 || confirmation === password;
    const canSubmit = requirementsMet && confirmation.length > 0 && passwordsMatch;

    return (
        <div className="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-background via-muted to-background p-4">
            <Head title="Reset password" />

            <main className="relative z-10 w-full max-w-md">
                <div className="mb-8 text-center">
                    <div className="mb-4 inline-flex size-16 items-center justify-center rounded-xl border border-border bg-medical-blue text-white shadow-sm">
                        <ShieldCheck className="size-8" />
                    </div>
                    <h1 className="mb-1 text-headline-lg font-heading tracking-tight text-foreground">
                        Secure Access
                    </h1>
                    <p className="text-body-md text-muted-foreground">
                        Update your credentials to continue to ClinicOS.
                    </p>
                </div>

                <div className="overflow-hidden rounded-xl border border-border bg-white shadow-[0px_4px_12px_rgba(15,23,42,0.08)]">
                    <div className="border-b border-border p-8">
                        <h2 className="mb-1 text-title-lg text-foreground">
                            Reset Password
                        </h2>
                        <p className="text-label-md text-muted-foreground">
                            Please create a new, strong password.
                        </p>
                    </div>

                    <Form
                        {...update.form()}
                        transform={(data) => ({ ...data, token, email })}
                        resetOnSuccess={['password', 'password_confirmation']}
                        className="space-y-6 p-8"
                    >
                        {({ processing, errors }) => (
                            <>
                                <div className="space-y-2">
                                    <label
                                        htmlFor="password"
                                        className="block text-label-md font-semibold text-foreground"
                                    >
                                        New Password
                                    </label>
                                    <PasswordField
                                        id="password"
                                        autoComplete="new-password"
                                        placeholder="Enter new password"
                                        autoFocus
                                        value={password}
                                        onChange={(e) => setPassword(e.target.value)}
                                        error={errors.password}
                                    />
                                </div>

                                <PasswordRequirements password={password} />

                                <div className="space-y-2">
                                    <label
                                        htmlFor="password_confirmation"
                                        className="block text-label-md font-semibold text-foreground"
                                    >
                                        Confirm Password
                                    </label>
                                    <PasswordField
                                        id="password_confirmation"
                                        autoComplete="new-password"
                                        placeholder="Re-enter new password"
                                        value={confirmation}
                                        onChange={(e) => setConfirmation(e.target.value)}
                                        error={
                                            errors.password_confirmation ??
                                            (!passwordsMatch
                                                ? 'Passwords do not match.'
                                                : undefined)
                                        }
                                    />
                                </div>

                                <button
                                    type="submit"
                                    disabled={!canSubmit || processing}
                                    className="flex w-full items-center justify-center gap-2 rounded-lg bg-clinical-teal px-6 py-2 text-label-md text-white shadow-sm transition-all hover:bg-clinical-teal-dark hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100 disabled:hover:bg-clinical-teal"
                                >
                                    {processing ? 'Resetting…' : 'Reset Password'}
                                    <ArrowRight className="size-[18px]" />
                                </button>
                            </>
                        )}
                    </Form>

                    <div className="border-t border-border bg-muted p-4 text-center">
                        <a
                            href="/login"
                            className="inline-flex items-center gap-1 text-label-md text-muted-foreground transition-colors hover:text-foreground"
                        >
                            <ArrowLeft className="size-4" />
                            Return to Login
                        </a>
                    </div>
                </div>

                <div className="mt-6 flex items-center justify-center gap-4 text-center text-label-sm text-muted-foreground opacity-70">
                    <span className="flex items-center gap-1">
                        <Lock className="size-3.5" />
                        End-to-End Encrypted
                    </span>
                    <span>•</span>
                    <span className="flex items-center gap-1">
                        <ShieldCheck className="size-3.5" />
                        HIPAA Compliant
                    </span>
                </div>
            </main>
        </div>
    );
}
