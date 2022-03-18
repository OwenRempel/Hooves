import { Link } from "react-router-dom"

function Back({ link }) {
    return <Link to={link}><button className="btn btn-small"><i className="arrow left"></i> Back</button></Link>
}

export default Back
