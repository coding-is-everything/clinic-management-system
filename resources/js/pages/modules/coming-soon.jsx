import { Head } from '@inertiajs/react';
import { getClinicModuleIcon } from '@/lib/clinic-module-icons';
import { dashboard } from '@/routes';

export default function ModuleComingSoon({ module }) {
    const Icon = getClinicModuleIcon(module.icon);

    return (
        <>
            <Head title={module.title} />
            <div className="flex h-full flex-1 flex-col items-center justify-center gap-6 p-8 text-center">
                <div className="flex size-14 items-center justify-center rounded-xl bg-clinical-teal/10 text-clinical-teal">
                    <Icon className="size-7" />
                </div>

                <div className="max-w-md space-y-2">
                    <h1 className="text-headline-md font-heading text-foreground">
                        {module.title}
                    </h1>
                    <p className="text-body-md text-muted-foreground">
                        {module.description}
                    </p>
                </div>

                <div className="flex max-w-lg flex-wrap justify-center gap-2">
                    {module.tables.map((table) => (
                        <span
                            key={table}
                            className="rounded-full border border-border bg-muted px-3 py-1 text-label-sm text-muted-foreground"
                        >
                            {table}
                        </span>
                    ))}
                </div>

                <p className="text-label-sm text-muted-foreground">
                    This module is coming soon.
                </p>
            </div>
        </>
    );
}

ModuleComingSoon.layout = (props) => ({
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: props.currentTeam ? dashboard(props.currentTeam.slug) : '/',
        },
        {
            title: props.module.title,
            href: '#',
        },
    ],
});
