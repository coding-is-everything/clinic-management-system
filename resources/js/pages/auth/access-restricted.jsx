import { Head, Link } from '@inertiajs/react';
import { CircleAlert, Mail, ShieldAlert } from 'lucide-react';
import AccessRestrictedTopbar from '@/components/auth/access-restricted-topbar';
import AuthFooterLinks from '@/components/auth/auth-footer-links';

export default function AccessRestricted({ restriction, administratorEmail }) {
    const mailHref = administratorEmail
        ? `mailto:${administratorEmail}?subject=${encodeURIComponent(
              `Account access — reference ${restriction.referenceCode}`,
          )}`
        : undefined;

    return (
        <div className="flex min-h-screen flex-col bg-background antialiased">
            <Head title="Account restricted" />

            <AccessRestrictedTopbar />

            <main className="flex flex-1 items-center justify-center p-4 md:p-8">
                <div className="w-full max-w-md overflow-hidden rounded-xl border border-border bg-white shadow-[0px_12px_32px_rgba(15,23,42,0.08)]">
                    <div className="flex items-center gap-2 border-b border-border bg-muted px-6 py-4">
                        <ShieldAlert className="size-5 text-muted-foreground" />
                        <span className="text-label-sm tracking-wider text-muted-foreground uppercase">
                            System Alert
                        </span>
                    </div>

                    <div className="flex flex-col items-center gap-6 p-6 text-center">
                        <div className="mb-2 flex size-16 items-center justify-center rounded-full bg-destructive/10">
                            <CircleAlert className="size-8 text-destructive" />
                        </div>

                        <div className="space-y-2">
                            <h1 className="text-headline-md font-heading text-foreground">
                                {restriction.title}
                            </h1>
                            <p className="mx-auto max-w-[280px] text-body-md text-muted-foreground">
                                {restriction.description}
                            </p>
                        </div>

                        <div className="flex w-full flex-col gap-3 pt-4">
                            {mailHref ? (
                                <a
                                    href={mailHref}
                                    className="flex w-full items-center justify-center gap-2 rounded-lg bg-clinical-teal px-4 py-[10px] text-label-md text-white transition-colors hover:bg-clinical-teal-dark"
                                >
                                    <Mail className="size-[18px]" />
                                    Contact Administrator
                                </a>
                            ) : (
                                <button
                                    type="button"
                                    disabled
                                    className="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-lg bg-muted px-4 py-[10px] text-label-md text-muted-foreground"
                                >
                                    <Mail className="size-[18px]" />
                                    No administrator on file
                                </button>
                            )}

                            <Link
                                href="/access-restricted/exit"
                                className="w-full rounded-lg border border-border bg-white px-4 py-[10px] text-center text-label-md text-medical-blue transition-colors hover:bg-muted"
                            >
                                Return to Login
                            </Link>
                        </div>

                        <div className="mt-2 w-full border-t border-border pt-4">
                            <p className="text-center text-label-sm text-muted-foreground/70">
                                Reference Code: {restriction.referenceCode}
                            </p>
                        </div>
                    </div>
                </div>
            </main>

            <AuthFooterLinks />
        </div>
    );
}
