import React from "react";
import useAxios from "axios-hooks";

import Loading from "./Loading";
import Error from "./Error";
import toast from "react-hot-toast";
import api from "./api";
import { useNavigate } from "react-router-dom";

const Reminder = () => {
    const [{ data, loading, error }, refetch] = useAxios("/api/reminders");
    const navigate = useNavigate();

    const handleDelete = async (id) => {
        try {
            await api.delete(`/api/reminders/${id}`);

            await refetch();
            toast.success("Success delete");
        } catch (error) {
            if (axios.isAxiosError(error)) {
                toast.error(error.response?.data?.msg, { duration: 10000 });
            } else {
                toast.error(error.message, { duration: 10000 });
            }
            console.log(error);
        }
    };

    const datetimeConverter = (ts) => {
        const d = new Date(ts * 1000);
        const year = d.getFullYear();
        const month = d.getMonth() + 1 < 10 ? `0${d.getMonth()}` : d.getMonth();
        const date = d.getDate() < 10 ? `0${d.getDate()}` : d.getDate();
        const hour = d.getHours() < 10 ? `0${d.getHours()}` : d.getHours();
        const minute =
            d.getMinutes() < 10 ? `0${d.getMinutes()}` : d.getMinutes();

        return `${date}-${month}-${year} ${hour}:${minute}`;
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
                        <div className="card-header">
                            Reminder
                            <button
                                className="btn btn-primary btn-sm float-end"
                                onClick={() => navigate("/reminder-create")}
                            >
                                Create
                            </button>
                        </div>

                        <div className="card-body">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Remind At</th>
                                        <th>Event At</th>
                                        <th colSpan={2}>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data.data.reminders.map((v, i) => (
                                        <tr key={i}>
                                            <td>{v.title}</td>
                                            <td>{v.description}</td>
                                            <td>
                                                {datetimeConverter(v.remind_at)}
                                            </td>
                                            <td>
                                                {datetimeConverter(v.event_at)}
                                            </td>
                                            <td>
                                                <button
                                                    className="btn btn-success btn-sm"
                                                    onClick={() =>
                                                        navigate(
                                                            `/reminder-update/${v.id}`
                                                        )
                                                    }
                                                >
                                                    Update
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    className="btn btn-danger btn-sm"
                                                    onClick={async () =>
                                                        await handleDelete(v.id)
                                                    }
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Reminder;
