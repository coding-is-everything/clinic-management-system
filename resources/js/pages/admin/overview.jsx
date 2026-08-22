import { Head, Link } from '@inertiajs/react';
import {
    ArrowRight,
    Building2,
    Info,
    UsersRound,
} from 'lucide-react';
import { dashboard } from '@/routes';

function StatCard({ icon: Icon, label, value }) {
    return (
        <div className="flex items-center gap-4 rounded-xl border border-border bg-white p-5 shadow-sm">
            <div className="flex size-10 shrink-0 items-center justify-center rounded-lg bg-clinical-teal/10 text-clinical-teal">
                <Icon className="size-5" />
            </div>
            <div>
                <p className="text-headline-lg font-heading text-foreground">
                    {value}
                </p>
                <p className="text-label-md text-muted-foreground uppercase">
                    {label}
                </p>
            </div>
        </div>
    );
}

function formatDate(iso) {
    if (!iso) return '—';

    return new Date(iso).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}

export default function PlatformOverview({ stats, tenants, appHost }) {
    return (
        <div className="flex flex-col gap-6">
            <Head title="Platform Overview" />

            <div>
                <h1 className="text-headline-lg font-heading text-foreground">
                    Platform Overview
                </h1>
                <p className="mt-1 text-body-md text-muted-foreground">
                    Real usage across every tenant on ClinicOS.
                </p>
            </div>

            <div className="grid gap-4 sm:grid-cols-3">
                <StatCard
                    icon={Building2}
                    label="Total Tenants"
                    value={stats.totalTenants}
                />
                <StatCard
                    icon={Building2}
                    label="Total Clinics"
                    value={stats.totalClinics}
                />
                <StatCard
                    icon={UsersRound}
                    label="Total Users"
                    value={stats.totalUsers}
                />
            </div>

            <div className="flex items-start gap-3 rounded-lg border border-amber-500/30 bg-amber-500/5 p-4">
                <Info className="mt-0.5 size-5 shrink-0 text-amber-600" />
                <p className="text-body-md text-foreground">
                    Billing, subscription plans, and platform uptime
                    monitoring aren&apos;t wired up yet, so those metrics
                    aren&apos;t shown here — only real, currently-computable
                    numbers are.
                </p>
            </div>

            <div className="overflow-hidden rounded-xl border border-border bg-white shadow-sm">
                <div className="border-b border-border bg-muted/50 px-4 py-3">
                    <h2 className="text-headline-md font-heading text-foreground">
                        Tenants
                    </h2>
                </div>

                {tenants.length === 0 ? (
                    <p className="p-8 text-center text-body-md text-muted-foreground">
                        No tenants yet.
                    </p>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full text-left">
                            <thead>
                                <tr className="border-b border-border">
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Tenant
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Owner
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Clinics
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Members
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Created
                                    </th>
                                    <th className="px-4 py-3 text-right text-label-md text-muted-foreground">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-border text-body-md text-foreground">
                                {tenants.map((tenant) => (
                                    <tr
                                        key={tenant.id}
                                        className="hover:bg-muted/30"
                                    >
                                        <td className="px-4 py-3">
                                            <div className="font-medium">
                                                {tenant.name}
                                            </div>
                                            <div className="text-body-sm text-muted-foreground">
                                                {appHost}/{tenant.slug}
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {tenant.ownerName ? (
                                                <>
                                                    <div>
                                                        {tenant.ownerName}
                                                    </div>
                                                    <div className="text-body-sm">
                                                        {tenant.ownerEmail}
                                                    </div>
                                                </>
                                            ) : (
                                                '—'
                                            )}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {tenant.clinicsCount}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {tenant.membersCount}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {formatDate(tenant.createdAt)}
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <Link
                                                href={dashboard(tenant.slug)}
                                                className="inline-flex items-center gap-1 text-label-md text-clinical-teal transition-colors hover:text-clinical-teal-dark"
                                            >
                                                View
                                                <ArrowRight className="size-3.5" />
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </div>
    );
}
