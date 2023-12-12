import React from "react";

const Error = ({ message }) => {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">{message}</div>
                </div>
            </div>
        </div>
    );
};

export default Error;
