export default function AuthFooterLinks() {
    return (
        <div className="w-full border-t border-border bg-muted p-4 text-center md:border-none md:bg-transparent">
            <div className="flex flex-wrap justify-center gap-x-6 gap-y-1 text-label-sm text-muted-foreground">
                <a className="transition-colors hover:text-clinical-teal" href="#">
                    Privacy Policy
                </a>
                <a className="transition-colors hover:text-clinical-teal" href="#">
                    Terms of Service
                </a>
                <a className="transition-colors hover:text-clinical-teal" href="#">
                    HIPAA Compliance
                </a>
            </div>
        </div>
    );
}
