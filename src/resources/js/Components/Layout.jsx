import React from "react";
import { Outlet, useNavigate } from "react-router-dom";

const Layout = () => {
    const navigate = useNavigate();

    return (
        <div>
            <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div className="container">
                    <a
                        className="navbar-brand"
                        href="#"
                        onClick={() => navigate("/reminder")}
                    >
                        Reminder
                    </a>
                </div>
            </nav>

            <main className="py-4">
                <Outlet />
            </main>
        </div>
    );
};

export default Layout;
