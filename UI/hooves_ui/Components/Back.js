import Link from "next/link"

function Back({ link }) {
    return <Link href={link}><button className="btn">Back</button></Link>
}

export default Back
