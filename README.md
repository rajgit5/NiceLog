# NiceLog | Log File Analyzer by Rajesh Sahu

## Overview
**NiceLog** is a web-based log file analyzer tool developed by **Rajesh Sahu**. This tool allows users to upload and analyze server log files, extracting key information and displaying it in a neatly formatted table. It highlights important data such as IP addresses, HTTP methods, requested URLs, and HTTP response codes, helping users easily identify patterns or issues within their log files.

## Features
- **Log File Upload:** Upload server log files through a simple web interface.
- **Log Entry Analysis:** Parses log files and extracts key data such as:
  - IP Address
  - Timestamp (adjusted by -90 minutes)
  - HTTP Method
  - Requested URL
  - HTTP Response Code
  - User-Agent
  - Referring URL
  - Protocol
- **Color-Coded Response Codes:**
  - `200 OK`: Green
  - `304 Not Modified`: Gray
  - `302 Found`: Red
- **Sorted Log Entries:** Automatically sorts log entries by timestamp in descending order.
- **Total Log Count:** Displays the total number of log entries processed.

## How to Use

1. **Upload a Log File:**
   - Click the "Choose a log file" button and upload a valid log file from your local system.
   - The log file format should follow this structure:
     ```plaintext
     IP_ADDRESS - - [TIMESTAMP] "METHOD URL PROTOCOL" RESPONSE_CODE SIZE "REFERRER" "USER_AGENT"
     ```

2. **Analyze:**
   - After selecting the log file, click the "Analyze" button to process the file.
   - The tool will parse the log entries and display them in a table, with color-coded HTTP response codes.

3. **Review the Results:**
   - Examine the table to review each log entry, with highlights for HTTP response codes and detailed information like the requested URL and user agent.

## Requirements
- A web server with PHP support to handle file uploads and log processing.
- Valid log files in the format mentioned above.

## Installation

1. Download or clone this repository to your web server's directory.
2. Ensure PHP is installed and configured on your server.
3. Open the tool in your web browser (e.g., `http://localhost/nicelog/`).
4. Start analyzing log files by uploading them through the interface.

## License
This project is licensed under the **MIT License**.

## Author
**Rajesh Sahu**  
Feel free to reach out for any questions or collaborations:  
- GitHub: https://github.com/rajgit5
- LinkedIn: https://www.linkedin.com/in/rajesh-rks/
