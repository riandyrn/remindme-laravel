import React, { useEffect } from "react";
import { useForm } from "react-hook-form";
import toast from "react-hot-toast";
import { useNavigate, useParams } from "react-router-dom";
import useAxios from "axios-hooks";

import Loading from "./Loading";
import Error from "./Error";
import api from "./api";

const ReminderUpdate = () => {
    const navigate = useNavigate();
    const params = useParams();

    const {
        register,
        handleSubmit,
        setValue,
        formState: { errors, isSubmitting },
    } = useForm();

    const [{ data, loading, error }, refetch] = useAxios(
        `/api/reminders/${params.id}`
    );

    useEffect(() => {
        if (!loading && !error) {
            setValue("title", data.data.title);
            setValue("description", data.data.description);
            setValue(
                "remind_at",
                new Date(data.data.remind_at * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
            setValue(
                "event_at",
                new Date(data.data.event_at * 1000)
                    .toISOString()
                    .substring(0, 16)
            );
        }
    }, [loading, error]);

    const onSubmit = async (data) => {
        try {
            const payload = {
                title: data.title,
                description: data.description,
                remind_at: new Date(data.remind_at).getTime() / 1000,
                event_at: new Date(data.event_at).getTime() / 1000,
            };
            await api.put(`/api/reminders/${params.id}`, payload);

            toast.success("Update reminder success");

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

    if (loading) {
        return <Loading />;
    }
    if (error) {
        return <Error message={error.message} />;
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Create Reminder</div>
                        <div className="card-body">
                            <form
                                method="POST"
                                onSubmit={handleSubmit(onSubmit)}
                            >
                                <div className="row mb-3">
                                    <label className="col-md-4 col-form-label text-md-end">
                                        Title
                                    </label>

                                    <div className="col-md-6">
                                        <input
                                            type="text"
                                            className={`form-control ${
                                                errors.title && "is-invalid"
                                            }`}
                                            {...register("title", {
                                                required: "Required",
                                            })}
                                        />
                                        {errors.title && (
                                            <span
                                                className="invalid-feedback"
                                                role="alert"
                                            >
                                                {errors.title.message}
                                            </span>
                                        )}
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <label className="col-md-4 col-form-label text-md-end">
                                        Description
                                    </label>

                                    <div className="col-md-6">
                                        <input
                                            type="text"
                                            className={`form-control ${
                                                errors.description &&
                                                "is-invalid"
                                            }`}
                                            {...register("description", {
                                                required: "Required",
                                            })}
                                        />
                                        {errors.description && (
                                            <span
                                                className="invalid-feedback"
                                                role="alert"
                                            >
                                                {errors.description.message}
                                            </span>
                                        )}
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <label className="col-md-4 col-form-label text-md-end">
                                        Remind At
                                    </label>

                                    <div className="col-md-6">
                                        <input
                                            type="datetime-local"
                                            className={`form-control ${
                                                errors.remind_at && "is-invalid"
                                            }`}
                                            {...register("remind_at", {
                                                required: "Required",
                                            })}
                                        />
                                        {errors.remind_at && (
                                            <span
                                                className="invalid-feedback"
                                                role="alert"
                                            >
                                                {errors.remind_at.message}
                                            </span>
                                        )}
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <label className="col-md-4 col-form-label text-md-end">
                                        Event At
                                    </label>

                                    <div className="col-md-6">
                                        <input
                                            type="datetime-local"
                                            className={`form-control ${
                                                errors.event_at && "is-invalid"
                                            }`}
                                            {...register("event_at", {
                                                required: "Required",
                                            })}
                                        />
                                        {errors.event_at && (
                                            <span
                                                className="invalid-feedback"
                                                role="alert"
                                            >
                                                {errors.event_at.message}
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
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ReminderUpdate;
