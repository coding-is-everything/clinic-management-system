import { CircleHelp, Globe } from 'lucide-react';

export default function AccessRestrictedTopbar() {
    return (
        <nav className="flex h-16 w-full flex-shrink-0 items-center justify-between border-b border-border bg-background px-4 md:px-6">
            <span className="font-heading text-headline-md font-bold text-medical-blue">
                ClinicOS
            </span>

            <div className="flex items-center gap-1">
                <button
                    type="button"
                    className="rounded-full p-2 text-muted-foreground transition-colors hover:bg-muted"
                    aria-label="Help"
                >
                    <CircleHelp className="size-5" />
                </button>
                <button
                    type="button"
                    className="rounded-full p-2 text-muted-foreground transition-colors hover:bg-muted"
                    aria-label="Language"
                >
                    <Globe className="size-5" />
                </button>
            </div>
        </nav>
    );
}
