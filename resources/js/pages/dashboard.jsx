import { Head } from '@inertiajs/react';
import {
    Building2,
    CalendarCheck,
    Receipt,
    Stethoscope,
    UserCheck,
} from 'lucide-react';
import { useState } from 'react';
import PendingInvitationsModal from '@/components/pending-invitations-modal';
import { dashboard } from '@/routes';

const STAT_ICONS = [CalendarCheck, UserCheck, Stethoscope, Receipt];

const ACCENTS = {
    teal: {
        badge: 'bg-clinical-teal',
        iconBg: 'bg-clinical-teal/10',
        iconText: 'text-clinical-teal',
    },
    rose: {
        badge: 'bg-rose-600',
        iconBg: 'bg-rose-600/10',
        iconText: 'text-rose-600',
    },
};

export default function Dashboard({ pendingInvitations = [], clinic }) {
    const [showInvitations, setShowInvitations] = useState(
        pendingInvitations.length > 0,
    );

    const accent = ACCENTS[clinic?.accent] ?? ACCENTS.teal;

    return (
        <>
            <Head title="Dashboard" />
            <PendingInvitationsModal
                invitations={pendingInvitations}
                open={pendingInvitations.length > 0 && showInvitations}
                onOpenChange={setShowInvitations}
            />

            <div className="flex h-full flex-1 flex-col gap-6 p-4">
                <div className="flex items-center gap-4 rounded-xl border border-border bg-white p-6 shadow-sm">
                    <div
                        className={`flex size-12 shrink-0 items-center justify-center rounded-xl text-white ${accent.badge}`}
                    >
                        <Building2 className="size-6" />
                    </div>
                    <div>
                        <h1 className="text-headline-md font-heading text-foreground">
                            {clinic?.name ?? 'Clinic'}
                        </h1>
                        <p className="text-body-md text-muted-foreground">
                            {clinic?.specialty}
                        </p>
                    </div>
                </div>

                <div className="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {(clinic?.stats ?? []).map((stat, index) => {
                        const Icon = STAT_ICONS[index] ?? Stethoscope;

                        return (
                            <div
                                key={stat.label}
                                className="flex items-center gap-4 rounded-xl border border-border bg-white p-5 shadow-sm"
                            >
                                <div
                                    className={`flex size-10 shrink-0 items-center justify-center rounded-lg ${accent.iconBg} ${accent.iconText}`}
                                >
                                    <Icon className="size-5" />
                                </div>
                                <div>
                                    <p className="text-headline-md font-heading text-foreground">
                                        {stat.value}
                                    </p>
                                    <p className="text-label-md text-muted-foreground">
                                        {stat.label}
                                    </p>
                                </div>
                            </div>
                        );
                    })}
                </div>

                <div className="flex min-h-[40vh] flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-border bg-white p-8 text-center">
                    <p className="text-body-md font-medium text-foreground">
                        No recent activity yet
                    </p>
                    <p className="mt-1 max-w-sm text-body-md text-muted-foreground">
                        Appointments, check-ins, and billing activity for{' '}
                        {clinic?.name ?? 'this clinic'} will show up here.
                    </p>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = (props) => ({
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
        },
    ],
});
