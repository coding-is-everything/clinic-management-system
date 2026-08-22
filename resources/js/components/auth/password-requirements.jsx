import { CheckCircle2, Circle } from 'lucide-react';

const REQUIREMENTS = [
    {
        id: 'length',
        label: 'At least 12 characters',
        test: (value) => value.length >= 12,
    },
    {
        id: 'uppercase',
        label: 'One uppercase letter',
        test: (value) => /[A-Z]/.test(value),
    },
    {
        id: 'lowercase',
        label: 'One lowercase letter',
        test: (value) => /[a-z]/.test(value),
    },
    {
        id: 'number',
        label: 'One number',
        test: (value) => /[0-9]/.test(value),
    },
    {
        id: 'symbol',
        label: 'One special character (!@#$%^&*)',
        test: (value) => /[^A-Za-z0-9]/.test(value),
        wide: true,
    },
];

export function checkPasswordRequirements(value) {
    return REQUIREMENTS.map((requirement) => ({
        id: requirement.id,
        label: requirement.label,
        wide: requirement.wide,
        met: requirement.test(value),
    }));
}

export function passwordMeetsRequirements(value) {
    return checkPasswordRequirements(value).every((requirement) => requirement.met);
}

export default function PasswordRequirements({ password }) {
    const results = checkPasswordRequirements(password);

    return (
        <div className="rounded-lg border border-border bg-muted p-4">
            <p className="mb-2 text-label-sm tracking-wider text-muted-foreground uppercase">
                Security Requirements
            </p>
            <div className="grid grid-cols-1 gap-x-4 gap-y-2 text-label-md text-muted-foreground md:grid-cols-2">
                {results.map((requirement) => (
                    <div
                        key={requirement.id}
                        className={`flex items-center gap-1 ${requirement.wide ? 'md:col-span-2' : ''}`}
                    >
                        {requirement.met ? (
                            <CheckCircle2 className="size-4 shrink-0 text-clinical-teal" />
                        ) : (
                            <Circle className="size-4 shrink-0 text-border" />
                        )}
                        <span className={requirement.met ? 'text-foreground' : undefined}>
                            {requirement.label}
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
}
