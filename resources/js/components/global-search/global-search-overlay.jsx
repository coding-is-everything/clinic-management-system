import { router, usePage } from '@inertiajs/react';
import { ArrowRight, Building2, Search, UserRound, X } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
} from '@/components/ui/dialog';

const STATUS_STYLES = {
    active: 'bg-clinical-teal/10 text-clinical-teal border-clinical-teal/20',
    inactive: 'bg-muted text-muted-foreground border-border',
    maintenance: 'bg-amber-500/10 text-amber-600 border-amber-500/20',
};

function highlight(text, query) {
    if (!query) return text;

    const index = text.toLowerCase().indexOf(query.toLowerCase());
    if (index === -1) return text;

    return (
        <>
            {text.slice(0, index)}
            <mark className="rounded-sm bg-clinical-teal/10 px-0.5 font-semibold text-clinical-teal">
                {text.slice(index, index + query.length)}
            </mark>
            {text.slice(index + query.length)}
        </>
    );
}

export default function GlobalSearchOverlay({ open, onOpenChange }) {
    const { props } = usePage();
    const teamSlug = props.currentTeam?.slug;

    const [query, setQuery] = useState('');
    const [results, setResults] = useState({ clinics: [], members: [] });
    const [activeIndex, setActiveIndex] = useState(0);
    const inputRef = useRef(null);
    const abortRef = useRef(null);

    const flatResults = [
        ...results.clinics.map((item) => ({ ...item, type: 'clinic' })),
        ...results.members.map((item) => ({ ...item, type: 'member' })),
    ];

    useEffect(() => {
        if (!open) return;

        setQuery('');
        setResults({ clinics: [], members: [] });
        setActiveIndex(0);

        const frame = requestAnimationFrame(() => inputRef.current?.focus());
        return () => cancelAnimationFrame(frame);
    }, [open]);

    useEffect(() => {
        if (!open || !teamSlug) return;

        const trimmed = query.trim();

        if (!trimmed) {
            setResults({ clinics: [], members: [] });
            return;
        }

        const controller = new AbortController();
        abortRef.current?.abort();
        abortRef.current = controller;

        const timeout = setTimeout(() => {
            fetch(
                `/${teamSlug}/search?q=${encodeURIComponent(trimmed)}`,
                { headers: { Accept: 'application/json' }, signal: controller.signal },
            )
                .then((response) => response.json())
                .then((data) => {
                    setResults(data);
                    setActiveIndex(0);
                })
                .catch((error) => {
                    if (error.name !== 'AbortError') {
                        setResults({ clinics: [], members: [] });
                    }
                });
        }, 200);

        return () => {
            clearTimeout(timeout);
            controller.abort();
        };
    }, [query, open, teamSlug]);

    const navigateTo = (href) => {
        onOpenChange(false);
        router.visit(href);
    };

    const handleKeyDown = (event) => {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            setActiveIndex((i) => Math.min(i + 1, flatResults.length - 1));
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            setActiveIndex((i) => Math.max(i - 1, 0));
        } else if (event.key === 'Enter') {
            event.preventDefault();
            const active = flatResults[activeIndex];
            if (active) navigateTo(active.href);
        }
    };

    const trimmedQuery = query.trim();
    let flatCursor = -1;

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="top-24 max-w-2xl translate-y-0 gap-0 overflow-hidden rounded-xl p-0 sm:max-w-2xl [&>button]:hidden">
                <DialogTitle className="sr-only">Global search</DialogTitle>
                <DialogDescription className="sr-only">
                    Search this workspace's clinics and team members.
                </DialogDescription>

                <div className="relative flex shrink-0 items-center border-b border-border p-4">
                    <Search className="pointer-events-none absolute left-6 size-5 text-muted-foreground" />
                    <input
                        ref={inputRef}
                        value={query}
                        onChange={(event) => setQuery(event.target.value)}
                        onKeyDown={handleKeyDown}
                        placeholder="Search clinics or team members…"
                        autoComplete="off"
                        spellCheck={false}
                        className="w-full border-0 bg-transparent py-3 pr-4 pl-9 text-body-lg text-foreground placeholder:text-muted-foreground/60 focus:ring-0 focus:outline-none"
                    />
                    <div className="absolute right-6 flex items-center gap-2">
                        {query && (
                            <button
                                type="button"
                                onClick={() => {
                                    setQuery('');
                                    inputRef.current?.focus();
                                }}
                                className="rounded-md p-1.5 text-muted-foreground transition-colors hover:bg-muted"
                                title="Clear search"
                            >
                                <X className="size-[18px]" />
                            </button>
                        )}
                        <div className="h-6 w-px bg-border" />
                        <kbd className="hidden items-center gap-1 rounded border border-border bg-muted px-2 py-1 text-[10px] text-muted-foreground shadow-sm sm:inline-flex">
                            ESC
                        </kbd>
                    </div>
                </div>

                <div className="max-h-[60vh] flex-1 overflow-y-auto bg-muted/30 p-2">
                    {!trimmedQuery && (
                        <p className="p-6 text-center text-body-md text-muted-foreground">
                            Start typing to search this workspace's clinics
                            and team members.
                        </p>
                    )}

                    {trimmedQuery &&
                        results.clinics.length === 0 &&
                        results.members.length === 0 && (
                            <p className="p-6 text-center text-body-md text-muted-foreground">
                                No results for &ldquo;{trimmedQuery}&rdquo;.
                            </p>
                        )}

                    {results.clinics.length > 0 && (
                        <div className="mb-2">
                            <div className="px-3 py-2 text-label-md text-muted-foreground uppercase tracking-wider">
                                Clinics
                            </div>
                            <ul className="space-y-1">
                                {results.clinics.map((clinic) => {
                                    flatCursor += 1;
                                    const index = flatCursor;

                                    return (
                                        <li key={`clinic-${clinic.id}`}>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    navigateTo(clinic.href)
                                                }
                                                onMouseEnter={() =>
                                                    setActiveIndex(index)
                                                }
                                                className={`group flex w-full items-center justify-between rounded-lg border p-3 text-left transition-all ${
                                                    activeIndex === index
                                                        ? 'border-border bg-white shadow-sm'
                                                        : 'border-transparent'
                                                }`}
                                            >
                                                <div className="flex items-center gap-4">
                                                    <div className="flex size-10 shrink-0 items-center justify-center rounded-lg bg-clinical-teal/10 text-clinical-teal">
                                                        <Building2 className="size-5" />
                                                    </div>
                                                    <div className="flex flex-col">
                                                        <span className="text-body-md font-medium text-foreground">
                                                            {highlight(
                                                                clinic.name,
                                                                trimmedQuery,
                                                            )}
                                                        </span>
                                                        <span className="text-body-sm text-muted-foreground">
                                                            {clinic.code}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="flex items-center gap-3">
                                                    <span
                                                        className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium capitalize ${
                                                            STATUS_STYLES[
                                                                clinic.status
                                                            ] ??
                                                            STATUS_STYLES.inactive
                                                        }`}
                                                    >
                                                        {clinic.status}
                                                    </span>
                                                    <ArrowRight className="size-4 text-muted-foreground/40 transition-colors group-hover:text-clinical-teal/70" />
                                                </div>
                                            </button>
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>
                    )}

                    {results.members.length > 0 && (
                        <div className="mb-2">
                            <div className="px-3 py-2 text-label-md text-muted-foreground uppercase tracking-wider">
                                Team Members
                            </div>
                            <ul className="space-y-1">
                                {results.members.map((member) => {
                                    flatCursor += 1;
                                    const index = flatCursor;

                                    return (
                                        <li key={`member-${member.id}`}>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    navigateTo(member.href)
                                                }
                                                onMouseEnter={() =>
                                                    setActiveIndex(index)
                                                }
                                                className={`group flex w-full items-center justify-between rounded-lg border p-3 text-left transition-all ${
                                                    activeIndex === index
                                                        ? 'border-border bg-white shadow-sm'
                                                        : 'border-transparent'
                                                }`}
                                            >
                                                <div className="flex items-center gap-4">
                                                    <div className="flex size-10 shrink-0 items-center justify-center rounded-full bg-medical-blue/10 text-medical-blue">
                                                        <UserRound className="size-5" />
                                                    </div>
                                                    <div className="flex flex-col">
                                                        <span className="text-body-md font-medium text-foreground">
                                                            {highlight(
                                                                member.name,
                                                                trimmedQuery,
                                                            )}
                                                        </span>
                                                        <span className="text-body-sm text-muted-foreground">
                                                            {member.roleLabel} •{' '}
                                                            {member.email}
                                                        </span>
                                                    </div>
                                                </div>
                                                <ArrowRight className="size-4 text-muted-foreground/40 transition-colors group-hover:text-clinical-teal/70" />
                                            </button>
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>
                    )}
                </div>

                <div className="flex shrink-0 items-center justify-between border-t border-border bg-muted/50 px-4 py-3">
                    <div className="flex items-center gap-4 text-label-md text-muted-foreground/80">
                        <span className="flex items-center gap-1">
                            <kbd className="rounded border border-border bg-white px-1.5 py-0.5 font-sans shadow-sm">
                                ↑
                            </kbd>
                            <kbd className="rounded border border-border bg-white px-1.5 py-0.5 font-sans shadow-sm">
                                ↓
                            </kbd>{' '}
                            to navigate
                        </span>
                        <span className="flex items-center gap-1">
                            <kbd className="rounded border border-border bg-white px-1.5 py-0.5 font-sans shadow-sm">
                                Enter
                            </kbd>{' '}
                            to select
                        </span>
                    </div>
                    <div className="text-body-sm text-muted-foreground">
                        {trimmedQuery
                            ? `Found ${flatResults.length} result${flatResults.length === 1 ? '' : 's'}`
                            : ''}
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
}
