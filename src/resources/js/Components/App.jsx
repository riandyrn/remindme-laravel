import React from "react";
import ReactDOM from "react-dom/client";
import { Routes, Route, BrowserRouter, useNavigate } from "react-router-dom";
import { Toaster } from "react-hot-toast";

import Login from "./Login";
import Layout from "./Layout";
import Reminder from "./Reminder";
import ReminderCreate from "./Loading";
import ReminderUpdate from "./ReminderUpdate";
import NoMatch from "./NoMatch";

import globalRouter from "./globalRouter";

function App() {
    const navigate = useNavigate();
    globalRouter.navigate = navigate;

    return (
        <Routes>
            <Route index element={<Login />} />
            <Route path="/" element={<Layout />}>
                <Route path="reminder" element={<Reminder />} />
                <Route path="reminder-create" element={<ReminderCreate />} />
                <Route
                    path="reminder-update/:id"
                    element={<ReminderUpdate />}
                />

                <Route path="*" element={<NoMatch />} />
            </Route>
        </Routes>
    );
}

export default App;

if (document.getElementById("app")) {
    const Index = ReactDOM.createRoot(document.getElementById("app"));

    Index.render(
        <React.StrictMode>
            <BrowserRouter>
                <App />
                <Toaster
                    position="top-right"
                    toastOptions={{ duration: 5000 }}
                />
            </BrowserRouter>
        </React.StrictMode>
    );
}
