export default function OnboardingStepIndicator({ step, totalSteps, label }) {
    return (
        <div className="mb-8 flex items-center gap-2">
            <span className="rounded bg-clinical-teal/10 px-2 py-1 text-label-md text-clinical-teal">
                Step {step} of {totalSteps}
            </span>
            <span className="text-sm text-muted-foreground">{label}</span>
        </div>
    );
}
