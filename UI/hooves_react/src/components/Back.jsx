import { Link } from "react-router-dom"

function Back({ link }) {
    return(
        <>
            <Link to={link} className="btn btn-small"><i className="arrow left"></i> Back</Link>
            <br></br>
        </>
    ) 
}

export default Back
