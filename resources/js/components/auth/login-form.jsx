import { Form } from '@inertiajs/react';
import { LogIn, User } from 'lucide-react';
import { request } from '@/routes/password';
import { store } from '@/routes/login';
import PasswordField from '@/components/auth/password-field';

export default function LoginForm({ canResetPassword }) {
    return (
        <Form
            {...store.form()}
            resetOnSuccess={['password']}
            disableWhileProcessing
            className="space-y-6"
        >
            {({ processing, errors }) => (
                <>
                    <div className="space-y-2">
                        <label
                            htmlFor="email"
                            className="block text-label-md font-semibold text-foreground"
                        >
                            Email or Mobile Number
                        </label>
                        <div className="relative">
                            <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2">
                                <User className="size-5 text-muted-foreground" />
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="text"
                                required
                                autoFocus
                                autoComplete="username"
                                placeholder="practitioner@clinic.com"
                                className="w-full rounded border border-border bg-white py-2 pr-2 pl-10 text-body-md text-foreground transition-all focus:border-clinical-teal focus:ring-2 focus:ring-clinical-teal/20 focus:outline-none"
                            />
                        </div>
                        {errors.email && (
                            <p className="text-sm text-destructive">
                                {errors.email}
                            </p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <div className="flex items-center justify-between">
                            <label
                                htmlFor="password"
                                className="block text-label-md font-semibold text-foreground"
                            >
                                Password
                            </label>
                            {canResetPassword && (
                                <a
                                    href={request()}
                                    className="text-label-md text-clinical-teal transition-colors hover:text-clinical-teal-dark"
                                >
                                    Forgot Password?
                                </a>
                            )}
                        </div>
                        <PasswordField
                            required
                            autoComplete="current-password"
                            placeholder="••••••••"
                            error={errors.password}
                        />
                    </div>

                    <div className="flex items-center">
                        <input
                            id="remember-me"
                            name="remember"
                            type="checkbox"
                            className="size-4 cursor-pointer rounded border-border bg-white text-clinical-teal focus:ring-clinical-teal"
                        />
                        <label
                            htmlFor="remember-me"
                            className="ml-2 block cursor-pointer text-body-md text-muted-foreground"
                        >
                            Remember me on this device
                        </label>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        data-test="login-button"
                        className="flex w-full items-center justify-center gap-1 rounded bg-clinical-teal px-4 py-2 text-label-md text-white transition-colors hover:bg-clinical-teal-dark disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        Sign In
                        <LogIn className="size-4" />
                    </button>
                </>
            )}
        </Form>
    );
}
