import axios from "axios";
import React from "react";
import { useForm } from "react-hook-form";
import toast from "react-hot-toast";
import { useNavigate } from "react-router-dom";
import api from "./api";

const Login = () => {
    const navigate = useNavigate();
    const {
        register,
        handleSubmit,
        formState: { errors, isSubmitting },
    } = useForm();

    const onSubmit = async (payload) => {
        try {
            const { data } = await api.post("/api/session", {
                email: payload.email,
                password: payload.password,
            });
            localStorage.setItem("refresh_token", data.data.refresh_token);
            localStorage.setItem("access_token", data.data.access_token);

            toast.success("Successfully login!");

            navigate("/reminder");
        } catch (error) {
            if (axios.isAxiosError(error)) {
                toast.error(error.response?.data?.msg, { duration: 10000 });
            } else {
                toast.error(error.message, { duration: 10000 });
            }
            console.log(error);
        }
    };

    return (
        <main className="py-4">
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Login</div>

                            <div className="card-body">
                                <form
                                    method="POST"
                                    onSubmit={handleSubmit(onSubmit)}
                                >
                                    <div className="row mb-3">
                                        <label className="col-md-4 col-form-label text-md-end">
                                            Email Address
                                        </label>

                                        <div className="col-md-6">
                                            <input
                                                type="email"
                                                className={`form-control ${
                                                    errors.email && "is-invalid"
                                                }`}
                                                {...register("email", {
                                                    required: "Required",
                                                })}
                                            />
                                            {errors.email && (
                                                <span
                                                    className="invalid-feedback"
                                                    role="alert"
                                                >
                                                    {errors.email.message}
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                    <div className="row mb-3">
                                        <label className="col-md-4 col-form-label text-md-end">
                                            Password
                                        </label>

                                        <div className="col-md-6">
                                            <input
                                                type="password"
                                                className={`form-control ${
                                                    errors.password &&
                                                    "is-invalid"
                                                }`}
                                                {...register("password", {
                                                    required: "Required",
                                                })}
                                            />
                                            {errors.email && (
                                                <span
                                                    className="invalid-feedback"
                                                    role="alert"
                                                >
                                                    {errors.password.message}
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                    <div className="row mb-0">
                                        <div className="col-md-8 offset-md-4">
                                            <button
                                                type="submit"
                                                className="btn btn-primary"
                                                disabled={isSubmitting}
                                            >
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
};

export default Login;
