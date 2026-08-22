import { Eye, EyeOff, Lock } from 'lucide-react';
import { useState } from 'react';

export default function PasswordField({ id = 'password', error, ...props }) {
    const [visible, setVisible] = useState(false);

    return (
        <div className="space-y-2">
            <div className="relative">
                <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                    <Lock className="size-5 text-muted-foreground" />
                </div>
                <input
                    id={id}
                    name={id}
                    type={visible ? 'text' : 'password'}
                    className="w-full rounded border border-border bg-white py-2 pr-10 pl-10 text-body-md text-foreground transition-all focus:border-clinical-teal focus:ring-2 focus:ring-clinical-teal/20 focus:outline-none"
                    {...props}
                />
                <button
                    type="button"
                    onClick={() => setVisible((prev) => !prev)}
                    className="absolute inset-y-0 right-0 flex items-center pr-2 text-muted-foreground transition-colors hover:text-foreground"
                    aria-label={visible ? 'Hide password' : 'Show password'}
                    tabIndex={-1}
                >
                    {visible ? (
                        <EyeOff className="size-5" />
                    ) : (
                        <Eye className="size-5" />
                    )}
                </button>
            </div>
            {error && (
                <p className="text-sm text-destructive">{error}</p>
            )}
        </div>
    );
}
