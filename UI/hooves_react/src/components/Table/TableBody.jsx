import TableRows from "./TableRows"
function TableBody({ Body, UrlKey }) {
    return(
        <tbody>
            {
                Body.map((j, i) => (
                    <tr key={i}>
                        {
                            <TableRows Rows={j} UrlKey={UrlKey} />
                        }
                    </tr>
                ))
            }
            
        </tbody>
    )
}

export default TableBody
