import TableRows from "./TableRows"
function TableBody({ Body, UrlKey, groupSelect, groupOnChange, groupList }) {
    return(
        <tbody>
            {
                Body.map((j, i) => (
                    <tr key={i} >
                        {groupSelect &&
                            <td>
                                <input type='checkbox' value={j.ID} onChange={groupOnChange} className="groupSelect" defaultChecked={groupList.includes(j.ID)}/>
                            </td>
                        }
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
