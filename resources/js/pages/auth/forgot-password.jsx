import { Form, Head } from '@inertiajs/react';
import { CircleUserRound, ShieldCheck } from 'lucide-react';
import InputError from '@/components/input-error';
import { email } from '@/routes/password';

export default function ForgotPassword({ status }) {
    return (
        <div className="flex min-h-screen items-center justify-center bg-background p-4 antialiased">
            <Head title="Forgot password" />

            <main className="w-full max-w-md">
                <div className="mb-8 text-center">
                    <div className="mb-2 inline-flex size-16 items-center justify-center rounded-full bg-medical-blue text-white">
                        <ShieldCheck className="size-8" />
                    </div>
                    <h1 className="text-headline-lg font-heading text-foreground">
                        ClinicOS
                    </h1>
                    <p className="mt-1 text-label-md text-muted-foreground">
                        Clinical Auth System
                    </p>
                </div>

                <div className="rounded-xl border border-border bg-white p-8 shadow-sm">
                    <div className="mb-6">
                        <h2 className="mb-2 text-title-lg text-foreground">
                            Forgot your password?
                        </h2>
                        <p className="text-body-md text-muted-foreground">
                            Enter your registered email address or mobile
                            number and we&apos;ll help you reset your
                            password.
                        </p>
                    </div>

                    {status && (
                        <p className="mb-6 text-body-md font-medium text-clinical-teal">
                            {status}
                        </p>
                    )}

                    <Form {...email.form()} className="space-y-6">
                        {({ processing, errors }) => (
                            <>
                                <div className="space-y-2">
                                    <label
                                        htmlFor="email"
                                        className="block text-label-md text-foreground"
                                    >
                                        Email / Mobile
                                    </label>
                                    <div className="relative">
                                        <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <CircleUserRound className="size-5 text-muted-foreground" />
                                        </div>
                                        <input
                                            id="email"
                                            name="email"
                                            type="text"
                                            required
                                            autoFocus
                                            autoComplete="off"
                                            placeholder="dr.smith@clinic.com"
                                            className="w-full rounded-lg border border-border bg-white py-2 pr-3 pl-10 text-body-md text-foreground transition-all focus:border-clinical-teal focus:ring-2 focus:ring-clinical-teal/20 focus:outline-none"
                                        />
                                    </div>
                                    <InputError message={errors.email} />
                                </div>

                                <div className="flex flex-col gap-2 pt-1">
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        data-test="email-password-reset-link-button"
                                        className="flex w-full items-center justify-center rounded-lg bg-clinical-teal px-4 py-2 text-label-md text-white transition-colors hover:bg-clinical-teal-dark disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        {processing
                                            ? 'Sending…'
                                            : 'Send Reset Link'}
                                    </button>
                                    <a
                                        href="/login"
                                        className="flex w-full items-center justify-center rounded-lg border border-border bg-white px-4 py-2 text-label-md text-foreground transition-colors hover:bg-muted"
                                    >
                                        Back to Login
                                    </a>
                                </div>
                            </>
                        )}
                    </Form>
                </div>

                <div className="mt-6 text-center text-label-sm text-muted-foreground">
                    Need further assistance?{' '}
                    <a
                        href="#"
                        className="ml-1 text-clinical-teal hover:underline"
                    >
                        Contact IT Support
                    </a>
                </div>
            </main>
        </div>
    );
}
