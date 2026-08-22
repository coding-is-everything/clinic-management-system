import {
    BarChart3,
    Boxes,
    Building2,
    CalendarClock,
    FlaskConical,
    IdCard,
    LayoutGrid,
    Pill,
    Receipt,
    Stethoscope,
    Users,
} from 'lucide-react';

// Explicit map so bundlers can tree-shake unused lucide icons — keep this in
// sync with the icon names used in App\Support\ClinicModules.
export const CLINIC_MODULE_ICONS = {
    BarChart3,
    Boxes,
    Building2,
    CalendarClock,
    FlaskConical,
    IdCard,
    Pill,
    Receipt,
    Stethoscope,
    Users,
};

export function getClinicModuleIcon(name) {
    return CLINIC_MODULE_ICONS[name] ?? LayoutGrid;
}
