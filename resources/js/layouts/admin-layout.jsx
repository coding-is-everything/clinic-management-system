import { Head, Link, usePage } from '@inertiajs/react';
import {
    ArrowLeftRight,
    BriefcaseMedical,
    CircleHelp,
    Globe,
    LayoutDashboard,
} from 'lucide-react';
import { useInitials } from '@/hooks/use-initials';
import { dashboard } from '@/routes';

const NAV_ITEMS = [{ key: 'overview', title: 'Overview', icon: LayoutDashboard, href: '/admin' }];

export default function AdminLayout({ children }) {
    const { props, url } = usePage();
    const user = props.auth?.user;
    const currentTeam = props.currentTeam;
    const getInitials = useInitials();

    return (
        <div className="flex min-h-screen bg-background">
            <Head title="Platform Admin" />

            <aside className="fixed top-0 left-0 flex h-screen w-64 flex-col bg-medical-blue py-6 text-white">
                <div className="flex items-center gap-3 px-6 pb-8">
                    <div className="flex size-8 shrink-0 items-center justify-center rounded-lg bg-clinical-teal">
                        <BriefcaseMedical className="size-5" />
                    </div>
                    <div>
                        <h1 className="font-heading text-headline-md font-bold text-white">
                            ClinicOS
                        </h1>
                        <p className="text-[10px] tracking-wider text-white/60 uppercase">
                            Platform Admin
                        </p>
                    </div>
                </div>

                <nav className="flex-1 space-y-1 px-3">
                    {NAV_ITEMS.map((item) => {
                        const isActive = url === item.href;

                        return (
                            <Link
                                key={item.key}
                                href={item.href}
                                className={`flex items-center gap-3 rounded-lg border-l-4 px-4 py-2 font-semibold transition-colors ${
                                    isActive
                                        ? 'border-clinical-teal bg-white/5 text-white'
                                        : 'border-transparent text-white/70 hover:bg-white/10 hover:text-white'
                                }`}
                            >
                                <item.icon className="size-5" />
                                {item.title}
                            </Link>
                        );
                    })}
                </nav>

                <div className="mt-auto space-y-1 border-t border-white/10 px-3 pt-4">
                    <Link
                        href={
                            currentTeam ? dashboard(currentTeam.slug) : '/'
                        }
                        className="flex items-center gap-3 rounded-lg px-4 py-2 text-white/70 transition-colors hover:bg-white/10 hover:text-white"
                    >
                        <ArrowLeftRight className="size-5" />
                        Back to my workspace
                    </Link>
                </div>
            </aside>

            <div className="ml-64 flex flex-1 flex-col">
                <header className="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-border bg-white px-6">
                    <span className="font-heading text-headline-md font-bold text-medical-blue">
                        ClinicOS Portal
                    </span>
                    <div className="flex items-center gap-1">
                        <button
                            type="button"
                            className="rounded-full p-2 text-muted-foreground transition-colors hover:bg-muted"
                        >
                            <CircleHelp className="size-5" />
                        </button>
                        <button
                            type="button"
                            className="rounded-full p-2 text-muted-foreground transition-colors hover:bg-muted"
                        >
                            <Globe className="size-5" />
                        </button>
                        <div className="ml-2 flex size-8 items-center justify-center rounded-full bg-clinical-teal/10 text-sm font-bold text-clinical-teal">
                            {user ? getInitials(user.name) : ''}
                        </div>
                    </div>
                </header>

                <main className="flex-1 p-6">{children}</main>
            </div>
        </div>
    );
}
