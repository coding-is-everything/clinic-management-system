import { useRef, useState } from 'react';

export default function OtpInputGroup({ length = 6, onChange, error }) {
    const [values, setValues] = useState(Array(length).fill(''));
    const inputRefs = useRef([]);

    const updateValues = (next) => {
        setValues(next);
        onChange?.(next.join(''));
    };

    const handleChange = (index, rawValue) => {
        const digit = rawValue.replace(/[^0-9]/g, '').slice(-1);
        const next = [...values];
        next[index] = digit;
        updateValues(next);

        if (digit && index < length - 1) {
            inputRefs.current[index + 1]?.focus();
        }
    };

    const handleKeyDown = (index, event) => {
        if (event.key === 'Backspace' && !values[index] && index > 0) {
            inputRefs.current[index - 1]?.focus();
        }
    };

    const handlePaste = (event) => {
        event.preventDefault();
        const pasted = event.clipboardData
            .getData('text')
            .replace(/[^0-9]/g, '')
            .slice(0, length);

        if (!pasted) return;

        const next = Array(length).fill('');
        for (let i = 0; i < pasted.length; i++) next[i] = pasted[i];
        updateValues(next);

        const focusIndex = Math.min(pasted.length, length - 1);
        inputRefs.current[focusIndex]?.focus();
    };

    return (
        <div className="flex justify-between gap-2">
            {values.map((digit, index) => (
                <input
                    key={index}
                    ref={(el) => {
                        inputRefs.current[index] = el;
                    }}
                    value={digit}
                    onChange={(e) => handleChange(index, e.target.value)}
                    onKeyDown={(e) => handleKeyDown(index, e)}
                    onPaste={handlePaste}
                    inputMode="numeric"
                    pattern="[0-9]*"
                    maxLength={1}
                    autoComplete="off"
                    autoFocus={index === 0}
                    aria-label={`Digit ${index + 1}`}
                    className={`h-14 w-12 rounded-lg border text-center text-title-lg text-foreground transition-all duration-200 focus:border-clinical-teal focus:shadow-[0_0_0_2px_rgba(13,148,136,0.2)] focus:outline-none ${
                        error ? 'border-destructive' : 'border-border'
                    }`}
                />
            ))}
        </div>
    );
}
