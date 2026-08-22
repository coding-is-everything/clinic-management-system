import { Head } from '@inertiajs/react';
import {
    Building2,
    CheckCircle2,
    Pencil,
    Plus,
    Stethoscope,
} from 'lucide-react';
import { useMemo, useState } from 'react';
import ClinicFormModal from '@/components/clinics/clinic-form-modal';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { dashboard } from '@/routes';

const STATUS_STYLES = {
    active: 'bg-clinical-teal/10 text-clinical-teal',
    inactive: 'bg-muted text-muted-foreground',
    maintenance: 'bg-amber-500/10 text-amber-600',
};

function StatCard({ icon: Icon, label, value }) {
    return (
        <div className="flex items-center gap-4 rounded-xl border border-border bg-white p-5 shadow-sm">
            <div className="flex size-10 shrink-0 items-center justify-center rounded-lg bg-clinical-teal/10 text-clinical-teal">
                <Icon className="size-5" />
            </div>
            <div>
                <p className="text-headline-md font-heading text-foreground">
                    {value}
                </p>
                <p className="text-label-md text-muted-foreground">{label}</p>
            </div>
        </div>
    );
}

export default function ClinicsIndex({ clinics, currentTeam }) {
    const [search, setSearch] = useState('');
    const [formOpen, setFormOpen] = useState(false);
    const [editingClinic, setEditingClinic] = useState(null);

    const filteredClinics = useMemo(() => {
        const query = search.trim().toLowerCase();

        if (!query) return clinics;

        return clinics.filter(
            (clinic) =>
                clinic.name.toLowerCase().includes(query) ||
                clinic.code.toLowerCase().includes(query),
        );
    }, [clinics, search]);

    const activeCount = clinics.filter((c) => c.status === 'active').length;
    const totalDoctors = clinics.reduce((sum, c) => sum + c.doctorCount, 0);

    const openCreate = () => {
        setEditingClinic(null);
        setFormOpen(true);
    };

    const openEdit = (clinic) => {
        setEditingClinic(clinic);
        setFormOpen(true);
    };

    return (
        <div className="flex h-full flex-1 flex-col gap-6 p-4">
            <Head title="Clinics & Branches" />

            <div className="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 className="text-headline-lg font-heading text-foreground">
                        Clinics &amp; Branches
                    </h1>
                    <p className="mt-1 text-body-md text-muted-foreground">
                        Manage your clinic locations, branches, and operating
                        configuration.
                    </p>
                </div>
                <Button onClick={openCreate}>
                    <Plus className="size-4" />
                    Add Clinic
                </Button>
            </div>

            <div className="grid gap-4 md:grid-cols-3">
                <StatCard
                    icon={Building2}
                    label="Total Branches"
                    value={clinics.length}
                />
                <StatCard
                    icon={CheckCircle2}
                    label="Active Branches"
                    value={activeCount}
                />
                <StatCard
                    icon={Stethoscope}
                    label="Total Doctors"
                    value={totalDoctors}
                />
            </div>

            <div className="flex flex-1 flex-col overflow-hidden rounded-xl border border-border bg-white shadow-sm">
                <div className="border-b border-border p-4">
                    <Input
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder="Search clinics by name or code…"
                        className="max-w-xs"
                    />
                </div>

                {clinics.length === 0 ? (
                    <div className="flex flex-1 flex-col items-center justify-center gap-2 p-12 text-center">
                        <div className="flex size-12 items-center justify-center rounded-full bg-clinical-teal/10 text-clinical-teal">
                            <Building2 className="size-6" />
                        </div>
                        <p className="text-body-md font-medium text-foreground">
                            No branches yet
                        </p>
                        <p className="max-w-sm text-body-md text-muted-foreground">
                            Add your first clinic location to start managing
                            branches under {currentTeam?.name ?? 'your workspace'}.
                        </p>
                        <Button className="mt-2" onClick={openCreate}>
                            <Plus className="size-4" />
                            Add Clinic
                        </Button>
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full text-left">
                            <thead>
                                <tr className="border-b border-border bg-muted/50">
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Clinic Name
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Code
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Location
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Doctors
                                    </th>
                                    <th className="px-4 py-3 text-label-md text-muted-foreground">
                                        Status
                                    </th>
                                    <th className="px-4 py-3 text-right text-label-md text-muted-foreground">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-border text-body-md text-foreground">
                                {filteredClinics.map((clinic) => (
                                    <tr
                                        key={clinic.id}
                                        className="hover:bg-muted/30"
                                    >
                                        <td className="px-4 py-3 font-medium">
                                            {clinic.name}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {clinic.code}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {[clinic.city, clinic.state]
                                                .filter(Boolean)
                                                .join(', ') || '—'}
                                        </td>
                                        <td className="px-4 py-3 text-muted-foreground">
                                            {clinic.doctorCount}
                                        </td>
                                        <td className="px-4 py-3">
                                            <span
                                                className={`inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-label-sm capitalize ${STATUS_STYLES[clinic.status] ?? STATUS_STYLES.inactive}`}
                                            >
                                                <span className="size-1.5 rounded-full bg-current" />
                                                {clinic.status}
                                            </span>
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    openEdit(clinic)
                                                }
                                                className="rounded p-1 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                                title="Edit"
                                            >
                                                <Pencil className="size-4" />
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>

            <ClinicFormModal
                team={currentTeam?.slug}
                clinic={editingClinic}
                open={formOpen}
                onOpenChange={setFormOpen}
            />
        </div>
    );
}

ClinicsIndex.layout = (props) => ({
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
        },
        {
            title: 'Clinics & Branches',
            href: '#',
        },
    ],
});
