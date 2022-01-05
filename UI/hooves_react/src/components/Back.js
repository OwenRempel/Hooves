import { Link } from "react-router-dom"

function Back({ link }) {
    return <Link to={link}><button className="btn">Back</button></Link>
}

export default Back
