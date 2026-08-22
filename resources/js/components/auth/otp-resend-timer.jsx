import { Clock } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';

export default function OtpResendTimer({ seconds = 45, onResend, resending }) {
    const [timeLeft, setTimeLeft] = useState(seconds);
    const intervalRef = useRef(null);

    useEffect(() => {
        intervalRef.current = setInterval(() => {
            setTimeLeft((prev) => (prev <= 1 ? 0 : prev - 1));
        }, 1000);

        return () => clearInterval(intervalRef.current);
    }, []);

    const handleResend = () => {
        onResend?.();
        setTimeLeft(seconds);
    };

    const minutes = Math.floor(timeLeft / 60)
        .toString()
        .padStart(2, '0');
    const secs = (timeLeft % 60).toString().padStart(2, '0');

    return (
        <div className="flex flex-col items-center gap-1 text-center">
            {timeLeft > 0 ? (
                <p className="flex items-center justify-center gap-1 text-data-mono text-muted-foreground">
                    <Clock className="size-4" />
                    Resend OTP in{' '}
                    <span className="font-medium text-foreground">
                        {minutes}:{secs}
                    </span>
                </p>
            ) : (
                <button
                    type="button"
                    onClick={handleResend}
                    disabled={resending}
                    className="text-label-md text-clinical-teal transition-colors hover:text-medical-blue disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {resending ? 'Sending…' : 'Resend OTP'}
                </button>
            )}
        </div>
    );
}
