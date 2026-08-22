import { Head, router } from '@inertiajs/react';
import { BriefcaseMedical, Lock } from 'lucide-react';
import { useState } from 'react';
import OtpInputGroup from '@/components/auth/otp-input-group';
import OtpResendTimer from '@/components/auth/otp-resend-timer';

export default function VerifyOtp({ maskedEmail }) {
    const [code, setCode] = useState('');
    const [error, setError] = useState('');
    const [processing, setProcessing] = useState(false);
    const [resending, setResending] = useState(false);
    const [resetKey, setResetKey] = useState(0);

    const submit = (event) => {
        event?.preventDefault();
        if (code.length !== 6 || processing) return;

        setProcessing(true);
        setError('');

        router.post(
            '/verify-otp',
            { code },
            {
                onError: (errors) =>
                    setError(errors.code ?? 'Something went wrong. Please try again.'),
                onFinish: () => setProcessing(false),
            },
        );
    };

    const handleResend = () => {
        setResending(true);
        setError('');

        router.post(
            '/verify-otp/resend',
            {},
            {
                onSuccess: () => {
                    setCode('');
                    setResetKey((key) => key + 1);
                },
                onError: (errors) => setError(errors.code ?? 'Could not resend the code.'),
                onFinish: () => setResending(false),
            },
        );
    };

    return (
        <div className="flex min-h-screen items-center justify-center bg-[#F8FAFC] p-4 antialiased">
            <Head title="Verify your identity" />

            <div className="flex w-full max-w-[440px] flex-col items-center">
                <div className="mb-6 flex items-center justify-center gap-2">
                    <div className="flex size-8 items-center justify-center rounded-lg bg-medical-blue text-white">
                        <BriefcaseMedical className="size-5" />
                    </div>
                    <h1 className="text-headline-md font-heading text-medical-blue">
                        ClinicOS
                    </h1>
                </div>

                <div className="w-full rounded-xl border border-border bg-white p-8 shadow-[0px_4px_12px_rgba(15,23,42,0.08)]">
                    <div className="mb-6 text-center">
                        <h2 className="mb-2 text-title-lg text-medical-blue">
                            Verify your identity
                        </h2>
                        <p className="text-body-md text-muted-foreground">
                            OTP sent to{' '}
                            <span className="text-label-md text-foreground">
                                {maskedEmail}
                            </span>
                        </p>
                    </div>

                    <form className="flex flex-col gap-6" onSubmit={submit}>
                        <OtpInputGroup
                            key={resetKey}
                            onChange={setCode}
                            error={error}
                        />

                        {error && (
                            <p className="-mt-4 text-center text-sm text-destructive">
                                {error}
                            </p>
                        )}

                        <OtpResendTimer
                            seconds={45}
                            onResend={handleResend}
                            resending={resending}
                        />

                        <div className="mt-2 flex flex-col gap-4">
                            <button
                                type="submit"
                                disabled={code.length !== 6 || processing}
                                className="flex w-full items-center justify-center gap-2 rounded-lg bg-clinical-teal px-4 py-3 text-label-md text-white transition-colors hover:bg-clinical-teal-dark disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {processing ? 'Verifying…' : 'Verify OTP'}
                            </button>
                            <a
                                href="/verify-otp/cancel"
                                className="w-full rounded-lg border border-border bg-transparent px-4 py-3 text-center text-label-md text-medical-blue transition-colors hover:bg-muted"
                            >
                                Use a different account
                            </a>
                        </div>
                    </form>

                    <div className="mt-6 flex items-center justify-center gap-2 border-t border-border pt-4 opacity-60">
                        <Lock className="size-4" />
                        <span className="text-label-sm tracking-wider uppercase">
                            Secure Clinical Environment
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
}
