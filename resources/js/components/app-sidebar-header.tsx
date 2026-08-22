import { Search } from 'lucide-react';
import { useEffect, useState } from 'react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import GlobalSearchOverlay from '@/components/global-search/global-search-overlay';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';

export function AppSidebarHeader({
    breadcrumbs = [],
}: {
    breadcrumbs?: BreadcrumbItemType[];
}) {
    const [searchOpen, setSearchOpen] = useState(false);

    useEffect(() => {
        function onKeyDown(event: KeyboardEvent) {
            if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                setSearchOpen((open) => !open);
            }
        }

        document.addEventListener('keydown', onKeyDown);
        return () => document.removeEventListener('keydown', onKeyDown);
    }, []);

    return (
        <header className="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-sidebar-border/50 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div className="flex items-center gap-2">
                <SidebarTrigger className="-ml-1" />
                <Breadcrumbs breadcrumbs={breadcrumbs} />
            </div>

            <button
                type="button"
                onClick={() => setSearchOpen(true)}
                className="flex items-center gap-2 rounded-lg border border-sidebar-border/70 px-3 py-1.5 text-sm text-muted-foreground transition-colors hover:bg-sidebar-accent"
            >
                <Search className="size-4" />
                <span className="hidden sm:inline">Search…</span>
                <kbd className="hidden items-center gap-0.5 rounded border border-sidebar-border/70 bg-background px-1.5 py-0.5 text-[10px] sm:inline-flex">
                    ⌘K
                </kbd>
            </button>

            <GlobalSearchOverlay open={searchOpen} onOpenChange={setSearchOpen} />
        </header>
    );
}
